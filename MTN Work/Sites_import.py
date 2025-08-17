import pandas as pd
import logging
import sys
import os
import numpy as np
import re
from datetime import datetime
from functools import reduce

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
    '2G': {
        'main_sheet': '2G Sites',
        'required_columns': [
            'Site code', 'Band', 'Site Status', 'BTS Type', 'BSC',
            'Site On Air Date', '900 Actual RBS Type', '900 On Air Date',
            '1800 Actual RBS Type', '1800 On Air Date', 'Notes', 'Real BSC',
            'Restoration date'
        ],
        'config_file': 'Cell Configuration 2G.xlsm',
        'config_sheet': '2G Cell Data',
        'merge_column': 'LAC',
        'merge_key_config': 'Site code'  # Key in configuration file
    },
    '3G': {
        'main_sheet': '3G Sites',
        'required_columns': [
            'Site code', 'WBTS ID', 'RNC', 'Site Status', 'On Air Date',
            'Renovation Date', 'Actual  Type', 'Number of Carriers',
            'E1 Actual', 'Notes', 'Real RNC', 'Restoration Date'
        ],
        'config_file': 'Cell Configuration 3G.xlsx',
        'config_sheet': 'Details',
        'skiprows': 1,
        'merge_column': 'LAC',
        'merge_key_config': 'Site code'  # Key in configuration file
    },
    '4G': {
        'main_sheet': 'LTE Sites',
        'required_columns': [
            'Site code', 'eNodeB ID', 'BTS Type', 
            'Status', 'Activation Date', 'Note', 
            'Restoration Date', 'Radio Plan'
        ],
        'config_file': 'Cell Configuration LTE.xlsx',
        'config_sheet': '4G Cell Data',
        'merge_column': 'TAC',
        'merge_key_config': 'Site code'  # Key in configuration file
    },
    '5G': {
        'main_sheet': '5G Sites',
        'required_columns': [
            'Site code', 'gNodeB ID', 'BTS Type', 
            'Status', 'Activation Date', 'Note', 
            'Restoration Date'
        ],
        'config_file': 'Cell Configuration 5G.xlsx',
        'config_sheet': '5G Cell Data',
        'merge_column': 'TAC',
        'merge_key_config': 'Site code'  # Key in configuration file
    },
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
                'priority': 1  # Highest priority
            },
            {
                'file': 'HW DB 5-8-2025.xlsx',
                'sheet': 'Data',
                'priority': 2
            },
            {
                'file': 'Cell Configuration 3G.xlsx',
                'sheet': 'Details',
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
    for tech, config in TECH_CONFIG.items():
        if tech == 'All_Sites':
            for source in config['sources']:
                if not os.path.exists(source['file']):
                    missing_files.append(source['file'])
        else:
            if 'config_file' in config and not os.path.exists(config['config_file']):
                missing_files.append(config['config_file'])
            if not os.path.exists('All Site Follow Up V2.0.xlsx'):
                missing_files.append('All Site Follow Up V2.0.xlsx')
    
    if missing_files:
        logging.error(f"Missing required files: {', '.join(set(missing_files))}")
        return False
    return True

def get_base_site_codes():
    """
    Collect unique site codes from main technology sheets (2G Sites, 3G Sites, LTE Sites)
    Returns a DataFrame with unique site codes or None if failed
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
            sheet_site_codes = df[site_code_col].astype(str).str.strip().str[:6].dropna().unique()
            site_codes.update(sheet_site_codes)
            logging.info(f"Found {len(sheet_site_codes)} site codes in {sheet_name}")
            
        except Exception as e:
            logging.error(f"Error processing sheet {sheet_name}: {str(e)}")
    
    if not site_codes:
        logging.error("No site codes found in any technology sheets")
        return None
    
    logging.info(f"Total unique site codes collected: {len(site_codes)}")
    return pd.DataFrame({'SITE_CODE': list(site_codes)})

def normalize_and_map_columns(df, config, priority=None):
    """
    Normalizes dataframe columns and maps to required columns with priority suffix
    Returns a DataFrame with mapped columns or None if site code not found
    """
    # Normalize columns
    normalized_columns = {col: normalize_col_name(col) for col in df.columns}
    df = df.rename(columns=normalized_columns)
    
    # Create output structure
    mapped_df = pd.DataFrame()
    site_code_found = False
    
    # Map site code with flexible matching
    for variant in config['site_code_variants']:
        norm_variant = normalize_col_name(variant)
        if norm_variant in df.columns:
            # Extract first 6 characters of site code
            mapped_df['SITE_CODE'] = df[norm_variant].astype(str).str.strip().str[:6]
            site_code_found = True
            break
    
    if not site_code_found:
        logging.warning(f"Site code column not found in source. Columns available: {list(df.columns)}")
        return None
    
    # Map other columns with priority suffix
    for col in config['required_columns']:
        if col == 'SITE_CODE':
            continue
            
        norm_col = normalize_col_name(col)
        if norm_col in df.columns:
            # Add priority suffix to column name
            mapped_df[f"{col}_P{priority}"] = df[norm_col]
        else:
            # Flexible matching for restoration dates
            if "RESTORATION" in norm_col:
                for col_name in df.columns:
                    if "RESTORATION" in col_name:
                        mapped_df[f"{col}_P{priority}"] = df[col_name]
                        break
    
    return mapped_df

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
        try:
            priority = source['priority']
            # Handle multi-sheet files
            if 'sheets' in source:
                for sheet_name in source['sheets']:
                    df = pd.read_excel(source['file'], sheet_name=sheet_name)
                    mapped_df = normalize_and_map_columns(df, config, priority)
                    if mapped_df is not None:  # Only add if site code was found
                        all_dfs.append(mapped_df)
            # Handle single-sheet files
            else:
                df = pd.read_excel(source['file'], sheet_name=source['sheet'])
                mapped_df = normalize_and_map_columns(df, config, priority)
                if mapped_df is not None:  # Only add if site code was found
                    all_dfs.append(mapped_df)
        except Exception as e:
            logging.error(f"Error processing {source.get('file', '')}: {e}")
    
    if len(all_dfs) == 1:  # Only base site codes
        logging.error("No valid data sources processed for All_Sites")
        return None
    
    # Merge all data sources
    try:
        # Start with base site codes
        merged = all_dfs[0]
        
        # Merge subsequent dataframes
        for i in range(1, len(all_dfs)):
            merged = pd.merge(
                merged, 
                all_dfs[i], 
                on='SITE_CODE',
                how='left',
                suffixes=('', '_DROP')
            )
            
            # Remove duplicate columns
            dup_cols = [c for c in merged.columns if '_DROP' in c]
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
    
    # Save and return result
    output_file = 'excel_final_All_Sites.xlsx'
    final_df.to_excel(output_file, index=False)
    logging.info(f"All_Sites consolidated data saved to {output_file}")
    return final_df

def process_tech_sites(tech):
    """
    Processes site data for a specific technology (2G, 3G, 4G, 5G)
    Returns processed DataFrame or None if processing fails
    """
    config = TECH_CONFIG[tech]
    
    try:
        # Read main site database
        df_main = pd.read_excel('All Site Follow Up V2.0.xlsx', sheet_name=config['main_sheet'])
        logging.info(f"Loaded main site data for {tech}")
    except Exception as e:
        logging.error(f"Error reading main site data for {tech}: {e}")
        return None
    
    # Normalize columns
    df_main.columns = [normalize_col_name(col) for col in df_main.columns]
    
    # Map required columns
    mapped_columns = {}
    missing_columns = []
    
    for req_col in config['required_columns']:
        norm_req = normalize_col_name(req_col)
        if norm_req in df_main.columns:
            mapped_columns[req_col] = norm_req
        else:
            # Flexible handling for restoration dates
            if "RESTORATION" in norm_req:
                for col_name in df_main.columns:
                    if "RESTORATION" in col_name:
                        mapped_columns[req_col] = col_name
                        break
                else:
                    missing_columns.append(req_col)
            else:
                missing_columns.append(req_col)
    
    if missing_columns:
        logging.warning(f"Missing columns in {tech} main data: {', '.join(missing_columns)}")
    
    # Filter and rename columns
    filtered = df_main.rename(columns={v: k for k, v in mapped_columns.items()})
    filtered = filtered[list(mapped_columns.keys())]
    
    # Clean site codes
    if 'Site code' in filtered.columns:
        filtered['Site code'] = filtered['Site code'].astype(str).str.strip().str[:6]
    
    # Save intermediate result
    output_file = f'excel2_{tech}.xlsx'
    filtered.to_excel(output_file, index=False)
    logging.info(f"Saved intermediate {tech} data to {output_file}")
    return filtered

def merge_tech_with_config(tech, tech_data):
    """
    Merges technology site data with configuration data
    Returns merged DataFrame or None if processing fails
    """
    config = TECH_CONFIG[tech]
    
    try:
        # Read configuration file
        if tech == '3G':
            df_config = pd.read_excel(
                config['config_file'],
                sheet_name=config['config_sheet'],
                skiprows=config.get('skiprows', 0)
            )
        else:
            df_config = pd.read_excel(
                config['config_file'],
                sheet_name=config['config_sheet']
            )
        logging.info(f"Loaded configuration data for {tech}")
    except Exception as e:
        logging.error(f"Error reading configuration for {tech}: {e}")
        return None
    
    # Normalize configuration columns
    df_config.columns = [normalize_col_name(col) for col in df_config.columns]
    
    # Find site code column in config
    site_code_col = None
    for variant in [normalize_col_name(v) for v in [config['merge_key_config'], 'SITE CODE', 'SITE_ID']]:
        if variant in df_config.columns:
            site_code_col = variant
            break
    
    if not site_code_col:
        logging.error(f"Site code column not found in {tech} configuration")
        return None
    
    # Clean config site codes
    df_config[site_code_col] = df_config[site_code_col].astype(str).str.strip().str[:6]
    
    # Find merge column in config
    merge_col = None
    for variant in [normalize_col_name(config['merge_column']), 'LAC', 'TAC']:
        if variant in df_config.columns:
            merge_col = variant
            break
    
    if not merge_col:
        logging.error(f"Merge column '{config['merge_column']}' not found in {tech} configuration")
        return None
    
    # Merge data
    merged = pd.merge(
        tech_data,
        df_config[[site_code_col, merge_col]],
        left_on='Site code',
        right_on=site_code_col,
        how='left'
    )
    
    # Clean up columns
    merged = merged.drop(columns=[site_code_col], errors='ignore')
    if merge_col != config['merge_column']:
        merged = merged.rename(columns={merge_col: config['merge_column']})
    
    # Save final result
    output_file = f'excel_final_{tech}.xlsx'
    merged.to_excel(output_file, index=False)
    logging.info(f"Saved final {tech} data to {output_file}")
    return merged

def main():
    """Main processing workflow"""
    logging.info("===== STARTING SITE DATA PROCESSING =====")
    start_time = datetime.now()
    
    if not validate_files():
        logging.error("File validation failed. Processing aborted.")
        return
    
    # Process All_Sites data first to get unique site codes
    all_sites_result = process_all_sites()
    if all_sites_result is None:
        logging.error("All_Sites processing failed")
    
    # Process technology-specific data
    for tech in ['2G', '3G', '4G', '5G']:
        try:
            logging.info(f"Processing {tech} sites...")
            tech_data = process_tech_sites(tech)
            if tech_data is not None:
                merged_data = merge_tech_with_config(tech, tech_data)
                if merged_data is None:
                    logging.warning(f"{tech} merge with config failed")
            else:
                logging.warning(f"{tech} site processing failed")
        except Exception as e:
            logging.error(f"Error processing {tech} sites: {str(e)}")
    
    # Calculate processing time
    duration = datetime.now() - start_time
    logging.info(f"===== PROCESSING COMPLETED IN {duration.total_seconds():.2f} SECONDS =====")

if __name__ == '__main__':
    main()
