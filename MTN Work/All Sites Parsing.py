import pandas as pd
import logging
import sys
import os
import numpy as np
from datetime import datetime

# Configure logging
logging.basicConfig(
    level=logging.INFO,
    format='%(asctime)s %(levelname)s: %(message)s',
    handlers=[
        logging.FileHandler(f"site_data_processing_{datetime.now().strftime('%Y%m%d_%H%M%S')}.log"),
        logging.StreamHandler(sys.stdout)
    ]
)

# Helper function to normalize column names
def normalize_col_name(col):
    return (str(col).strip().upper()
            .replace('_', ' ').replace('-', ' ').replace('.', ' ')
            .replace('  ', ' ').strip())

# Technology configuration settings
TECH_CONFIG = {
    'All_Sites': {
        'required_columns': [
            'SITE_CODE', 'SITE_NAME', 'ZONE', 'PROVINCE', 'C/R',
            'SUPPLIER', 'BSC', 'POWER_BACKUP', 'SITE_ON_AIR_DATE',
            'RELOCATION_DATE', 'COORDINATES_E', 'COORDINATES_N', 'ALTITUDE',
            'SITE_ADDRESS', 'ARABIC_NAME', 'TX_NODE', 'TECHNICAL_PRIORITY',
            'ADMINISTRATIVE_AREA', 'NODE_CATEGORY', 'SITE_RANKING',
            'SUBCONTRACTOR', 'INVOICE_TYPOLOGY'
        ],
        'site_code_variants': ['SITE CODE', 'SITE_ID', 'SITE ID', 'SITE'],
        'sources': [
            {
                'file': 'All Site Follow Up V2.0.xlsx',
                'sheets': ['2G Sites', '3G Sites', 'LTE Sites'],
                'priority': 1
            },
            {
                'file': 'HW DB 5-8-2025.xlsx',
                'sheet': 'Data',
                'priority': 2
            },
            {
                'file': 'Cell Configuration 3G.xlsx',
                'sheet': 'Details',
                'skiprows': 1,
                'site_code_col': 'CELL ID',  # Manual column specification
                'priority': 3
            },
            {
                'file': 'Cell Configuration LTE.xlsx',
                'sheet': '4G Cell Data',
                'priority': 4
            }
        ],
    }
}

def validate_files():
    """Check if required files exist in the current directory"""
    missing_files = []
    config = TECH_CONFIG['All_Sites']
    
    for source in config['sources']:
        if not os.path.exists(source['file']):
            missing_files.append(source['file'])
    
    if missing_files:
        logging.error(f"Missing required files: {', '.join(set(missing_files))}")
        return False
    return True

def handle_duplicates(df, id_column, context=""):
    """
    Handle duplicate values in a DataFrame by keeping the first occurrence.
    Logs duplicates found for troubleshooting.
    """
    duplicates = df.duplicated(subset=[id_column], keep=False)
    duplicate_count = duplicates.sum()
    
    if duplicate_count > 0:
        # Get top 5 duplicate examples
        dup_examples = df[duplicates][id_column].value_counts().head(5).to_dict()
        logging.warning(
            f"Found {duplicate_count} duplicates for {id_column} in {context}. "
            f"Top duplicates: {dup_examples}. Keeping first occurrence."
        )
        return df.drop_duplicates(subset=[id_column], keep='first')
    return df

def get_base_site_codes():
    """
    Collect unique site codes from main technology sheets (2G Sites, 3G Sites, LTE Sites)
    Returns a DataFrame with unique site codes
    """
    logging.info("Collecting base site codes from technology sheets")
    site_codes = set()
    sheets_to_process = ['2G Sites', '3G Sites', 'LTE Sites']
    
    for sheet_name in sheets_to_process:
        try:
            df = pd.read_excel('All Site Follow Up V2.0.xlsx', sheet_name=sheet_name)
            logging.info(f"Processing sheet: {sheet_name}")
            
            # Normalize column names
            df.columns = [normalize_col_name(col) for col in df.columns]
            
            # Find site code column
            site_code_col = None
            for variant in ['SITE CODE', 'SITE_ID', 'SITE ID', 'SITE']:
                if variant in df.columns:
                    site_code_col = variant
                    break
            
            if not site_code_col:
                logging.warning(f"Site code column not found in sheet: {sheet_name}")
                continue
            
            # Extract and clean site codes
            df[site_code_col] = df[site_code_col].astype(str).str.strip().str[:6]
            clean_codes = df[site_code_col].dropna().unique()
            site_codes.update(clean_codes)
            logging.info(f"Found {len(clean_codes)} site codes in {sheet_name}")
            
        except Exception as e:
            logging.error(f"Error processing sheet {sheet_name}: {str(e)}")
    
    if not site_codes:
        logging.error("No site codes found in any technology sheets")
        return None
    
    logging.info(f"Total unique site codes collected: {len(site_codes)}")
    return pd.DataFrame({'SITE_CODE': list(site_codes)})

def process_data_source(source, config):
    """
    Process a single data source with duplicate handling
    Returns processed DataFrame or None if processing fails
    """
    try:
        priority = source['priority']
        dfs = []
        skiprows = source.get('skiprows', 0)
        
        # Handle multi-sheet files
        if 'sheets' in source:
            for sheet_name in source['sheets']:
                df = pd.read_excel(source['file'], sheet_name=sheet_name, skiprows=skiprows)
                logging.info(f"Processing sheet: {sheet_name} in {source['file']}")
                
                # Process this sheet
                mapped_df = normalize_and_map_columns(df, config, priority, source)
                if mapped_df is not None:
                    dfs.append(mapped_df)
        # Handle single-sheet files
        else:
            df = pd.read_excel(source['file'], sheet_name=source['sheet'], skiprows=skiprows)
            logging.info(f"Processing sheet: {source['sheet']} in {source['file']}")
            mapped_df = normalize_and_map_columns(df, config, priority, source)
            if mapped_df is not None:
                dfs.append(mapped_df)
        
        # Combine all sheets if multiple
        if dfs:
            combined = pd.concat(dfs, ignore_index=True)
            
            # Remove duplicate site codes (keep first occurrence)
            if not combined.empty:
                combined = handle_duplicates(
                    combined, 
                    'SITE_CODE', 
                    f"{source['file']} (priority {priority})"
                )
                return combined
        
        return None
        
    except Exception as e:
        logging.error(f"Error processing {source.get('file', '')}: {e}")
        return None

def normalize_and_map_columns(df, config, priority=None, source=None):
    """
    Normalize columns and map to required columns with priority suffix
    Returns DataFrame with mapped columns or None if site code not found
    """
    # Normalize columns
    normalized_columns = {col: normalize_col_name(col) for col in df.columns}
    df = df.rename(columns=normalized_columns)
    
    # Create output structure
    mapped_df = pd.DataFrame()
    site_code_found = False
    
    # Use manually specified site code column if provided
    if source and 'site_code_col' in source:
        site_code_col = source['site_code_col']
        if site_code_col in df.columns:
            # Extract first 6 characters of site code
            mapped_df['SITE_CODE'] = df[site_code_col].astype(str).str.strip().str[:6]
            site_code_found = True
            logging.info(f"Using manually specified site code column: {site_code_col}")
    
    # Map site code with flexible matching
    if not site_code_found:
        for variant in config['site_code_variants']:
            norm_variant = normalize_col_name(variant)
            if norm_variant in df.columns:
                # Extract first 6 characters of site code
                mapped_df['SITE_CODE'] = df[norm_variant].astype(str).str.strip().str[:6]
                site_code_found = True
                break
    
    if not site_code_found:
        logging.warning(f"Site code column not found. Columns available: {list(df.columns)}")
        return None
    
    # Map other columns with priority suffix
    for col in config['required_columns']:
        if col == 'SITE_CODE':
            continue
            
        norm_col = normalize_col_name(col)
        if norm_col in df.columns:
            # Add priority suffix to column name
            mapped_df[f"{col}_P{priority}"] = df[norm_col]
    
    return mapped_df

def fill_missing_data(final_df, config):
    """Attempt to fill missing data from alternative sources"""
    logging.info("Attempting to fill missing data from alternative sources")
    
    # Create a mapping of alternative sources for each column
    fill_sources = {
        'C/R': ['CITY/RURAL', 'CR', 'C_R'],
        'SITE_ON_AIR_DATE': ['ON_AIR_DATE', 'ACTIVATION_DATE'],
        'RELOCATION_DATE': ['MOVE_DATE', 'RELOCATION'],
        'ARABIC_NAME': ['SITE_NAME_AR', 'ARABIC_NAME'],
        'TX_NODE': ['TRANSMISSION_NODE', 'TX_NODE_ID'],
        'TECHNICAL_PRIORITY': ['PRIORITY', 'TECH_PRIORITY'],
        'NODE_CATEGORY': ['NODE_TYPE', 'CATEGORY'],
        'SITE_RANKING': ['RANK', 'RANKING'],
        'SUBCONTRACTOR': ['VENDOR', 'CONTRACTOR'],
        'INVOICE_TYPOLOGY': ['INVOICE_TYPE', 'BILLING_TYPE']
    }
    
    for col, alternatives in fill_sources.items():
        if col not in final_df.columns:
            continue
            
        # Check if column has missing values
        null_mask = final_df[col].isnull()
        if not null_mask.any():
            continue
            
        # Try to fill from alternative columns
        for alt_col in alternatives:
            if alt_col in final_df.columns:
                # Fill only where original is null and alternative has value
                fill_mask = null_mask & final_df[alt_col].notnull()
                final_df.loc[fill_mask, col] = final_df.loc[fill_mask, alt_col]
                filled_count = fill_mask.sum()
                
                if filled_count > 0:
                    logging.info(
                        f"Filled {filled_count} missing values in {col} "
                        f"from {alt_col}"
                    )
    
    return final_df

def process_all_sites():
    """
    Consolidates site information from multiple sources for All_Sites
    Returns consolidated DataFrame or None if processing fails
    """
    logging.info("Processing All_Sites data from multiple sources")
    config = TECH_CONFIG['All_Sites']
    
    # Get base site codes first
    base_df = get_base_site_codes()
    if base_df is None:
        logging.error("Failed to get base site codes")
        return None
    
    all_dfs = [base_df]
    
    # Process each data source
    for source in config['sources']:
        processed_source = process_data_source(source, config)
        if processed_source is not None:
            all_dfs.append(processed_source)
    
    if len(all_dfs) == 1:  # Only base site codes
        logging.error("No valid data sources processed for All_Sites")
        return None
    
    # Merge all data sources
    try:
        # Start with base site codes
        merged = all_dfs[0]
        
        # Merge subsequent dataframes
        for i in range(1, len(all_dfs)):
            # Perform a left join to preserve base structure
            merged = pd.merge(
                merged, 
                all_dfs[i], 
                on='SITE_CODE',
                how='left',
                suffixes=('', '_DROP')
            )
            
            # Remove duplicate columns
            dup_cols = [c for c in merged.columns if '_DROP' in c]
            if dup_cols:
                merged = merged.drop(columns=dup_cols)
            
        logging.info(f"Merged {len(all_dfs)} data sources for All_Sites")
    except Exception as e:
        logging.error(f"Error merging All_Sites data: {e}")
        return None
    
    # Consolidate values based on priority
    consolidated_data = {'SITE_CODE': merged['SITE_CODE']}
    
    for col in config['required_columns']:
        if col == 'SITE_CODE':
            continue
            
        # Get all priority columns for this field
        priority_cols = [c for c in merged.columns if c.startswith(f"{col}_P")]
        
        if not priority_cols:
            consolidated_data[col] = None
            continue
            
        # Sort columns by priority (ascending)
        priority_cols.sort(key=lambda x: int(x.split('_P')[-1]))
        
        # Create selection matrix
        selection = merged[priority_cols]
        
        # Vectorized approach to get first non-null value
        mask = selection.notnull()
        first_valid = mask.idxmax(axis=1)
        no_valid = mask.sum(axis=1) == 0
        
        # Initialize result array
        values = np.empty(len(selection), dtype=object)
        
        # Process rows with valid values
        valid_rows = first_valid[~no_valid]
        for idx, col_name in valid_rows.items():
            values[idx] = selection.at[idx, col_name]
        
        # Set rows with no valid values to None
        values[no_valid] = None
        
        consolidated_data[col] = values
    
    # Create final dataframe
    final_df = pd.DataFrame(consolidated_data)
    
    # Fill missing data from alternative sources
    final_df = fill_missing_data(final_df, config)
    
    # Remove any potential duplicates that might have been introduced
    final_df = handle_duplicates(final_df, 'SITE_CODE', "final All_Sites output")
    
    # Save and return result
    output_file = 'excel_final_All_Sites.xlsx'
    final_df.to_excel(output_file, index=False)
    logging.info(f"All_Sites consolidated data saved to {output_file}")
    
    # Generate data quality report
    generate_quality_report(final_df, config['required_columns'])
    
    return final_df

def generate_quality_report(df, columns):
    """Generate data quality report for the final output"""
    report = {
        "total_sites": len(df),
        "columns_with_missing": {}
    }
    
    for col in columns:
        if col == 'SITE_CODE':
            continue
            
        null_count = df[col].isnull().sum()
        if null_count > 0:
            report["columns_with_missing"][col] = {
                "missing_count": null_count,
                "completeness": f"{(1 - null_count/len(df)) * 100:.2f}%"
            }
    
    # Duplicates check (should be 0 after our handling)
    duplicate_count = df.duplicated(subset=['SITE_CODE']).sum()
    report["duplicate_site_codes"] = duplicate_count
    
    logging.info("\n===== DATA QUALITY REPORT =====")
    logging.info(f"Total sites: {report['total_sites']}")
    logging.info(f"Duplicate site codes: {duplicate_count}")
    
    if report["columns_with_missing"]:
        logging.info("\nColumns with missing values:")
        for col, stats in report["columns_with_missing"].items():
            logging.info(f"- {col}: {stats['missing_count']} missing ({stats['completeness']} complete)")
    else:
        logging.info("No missing values in any columns")
    
    logging.info("=" * 30)

def main():
    """Main processing workflow"""
    logging.info("===== STARTING SITE DATA PROCESSING =====")
    start_time = datetime.now()
    
    if not validate_files():
        logging.error("File validation failed. Processing aborted.")
        return
    
    # Process All_Sites data
    all_sites_result = process_all_sites()
    
    # Calculate processing time
    duration = datetime.now() - start_time
    logging.info(f"===== PROCESSING COMPLETED IN {duration.total_seconds():.2f} SECONDS =====")

if __name__ == '__main__':
    main()