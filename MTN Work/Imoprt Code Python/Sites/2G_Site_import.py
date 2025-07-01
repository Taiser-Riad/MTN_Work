import pandas as pd
import logging
import sys

# Configure logging
logging.basicConfig(
    level=logging.INFO,
    format='%(asctime)s %(levelname)s: %(message)s',
    handlers=[
        logging.FileHandler("site_data_processing.log"),
        logging.StreamHandler(sys.stdout)
    ]
)

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
        'merge_column': 'LAC'
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
        'merge_column': 'LAC'
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
        'merge_column': 'TAC'
    },
    '5G': {
        'main_sheet': '5G Sites',
        'required_columns': [
            'Site code', 'gNodeB ID', 'BTS Type', 
            'Status', 'Activation Date', 'Note', 
            'Restoration Date', 'Radio Plan'
        ],
        'config_file': 'Cell Configuration 5G.xlsx',
        'config_sheet': '5G Cell Data',
        'merge_column': 'TAC'
    }
}

def filter_main_file(tech):
    """
    Filters the main site database for the specified technology
    """
    config = TECH_CONFIG[tech]
    try:
        # Read the main site database
        df = pd.read_excel('All Site Follow Up V2.0.xlsx', sheet_name=config['main_sheet'])
        logging.info(f"Successfully read main site database for {tech}")
    except Exception as e:
        logging.error(f"Failed to read main site database for {tech}: {e}")
        return None

    # Log available columns for debugging
    logging.info(f"Available columns in {tech} main file:")
    logging.info(df.columns.tolist())

    # Map available columns to normalized names (uppercase, stripped)
    available_cols_dict = {col.strip().upper(): col for col in df.columns}
    
    # Find matching columns for required columns
    actual_required_columns = []
    missing = []
    for req in config['required_columns']:
        req_upper = req.strip().upper()
        if req_upper in available_cols_dict:
            actual_required_columns.append(available_cols_dict[req_upper])
        else:
            # Handle common variants for "Restoration Date"
            if "RESTORATION" in req_upper:
                found = False
                for key in available_cols_dict:
                    if "RESTORATION" in key:
                        actual_required_columns.append(available_cols_dict[key])
                        # Standardize column name
                        df.rename(columns={available_cols_dict[key]: req}, inplace=True)
                        found = True
                        break
                if not found:
                    missing.append(req)
            else:
                missing.append(req)

    if missing:
        logging.error(f"Missing required columns in {tech} main file: {missing}")
        return None

    # Filter rows where Site code is not null
    site_code_col = [col for col in actual_required_columns if "SITE CODE" in col.upper()][0]
    condition = df[site_code_col].notnull()
    filtered = df.loc[condition, actual_required_columns]
    
    # Save filtered data to intermediate file
    output_file = f'excel2_{tech}.xlsx'
    try:
        filtered.to_excel(output_file, index=False)
        logging.info(f"Filtered {tech} data saved to '{output_file}'")
    except Exception as e:
        logging.error(f"Failed to save filtered {tech} data: {e}")
        return None

    return filtered

def merge_with_config(tech):
    """
    Merges filtered site data with configuration data for the specified technology
    """
    config = TECH_CONFIG[tech]
    input_file = f'excel2_{tech}.xlsx'
    
    try:
        df_result = pd.read_excel(input_file)
        logging.info(f"Loaded filtered {tech} data from '{input_file}'")
    except Exception as e:
        logging.error(f"Failed to read filtered {tech} data: {e}")
        return None

    try:
        # Read configuration file with technology-specific settings
        df_config = pd.read_excel(
            config['config_file'],
            sheet_name=config['config_sheet']
        )
        logging.info(f"Successfully read {tech} configuration file")
    except Exception as e:
        logging.error(f"Failed to read {tech} configuration file: {e}")
        return None

    # Log available columns for debugging
    logging.info(f"Available columns in {tech} configuration file:")
    logging.info(df_config.columns.tolist())

    # Remove any existing merge column from the result
    if config['merge_column'] in df_result.columns:
        df_result = df_result.drop(columns=[config['merge_column']])

    # Find site code column in configuration file
    site_code_variants = ['Site code', 'Site Code']
    site_code_col = None
    for variant in site_code_variants:
        if variant in df_config.columns:
            site_code_col = variant
            break
    
    if not site_code_col:
        logging.error(f"Site code column not found in {tech} configuration file")
        return None
    
    # Remove duplicates before merging
    df_result = df_result.drop_duplicates(subset=['Site code'])
    df_config = df_config.drop_duplicates(subset=[site_code_col])
    
    # Check if merge column exists in configuration
    if config['merge_column'] not in df_config.columns:
        logging.error(f"Merge column '{config['merge_column']}' not found in {tech} configuration")
        return None

    # Perform the merge (FIXED SYNTAX ERROR HERE)
    try:
        merged = pd.merge(
            df_result,
            df_config[site_code_col, config['merge_column']],  # FIXED: Using square brackets
            left_on='Site code',
            right_on=site_code_col,
            how='left'
        )
        # Remove the duplicate site code column if needed
        if site_code_col != 'Site code':
            merged = merged.drop(columns=[site_code_col])
        
        logging.info(f"Successfully merged {tech} data with configuration")
    except Exception as e:
        logging.error(f"Failed to merge {tech} data: {e}")
        return None

    # Save final merged data
    output_file = f'excel_final_{tech}.xlsx'
    try:
        merged.to_excel(output_file, index=False)
        logging.info(f"Merged {tech} data saved to '{output_file}'")
    except Exception as e:
        logging.error(f"Failed to save merged {tech} data: {e}")
        return None

    return merged

if __name__ == '__main__':
    logging.info("===== Starting site data processing =====")
    
    # Process all technologies
    for tech in ['2G', '3G', '4G', '5G']:
        logging.info(f"===== Processing {tech} data =====")
        
        # Filter main site data
        filtered_df = filter_main_file(tech)
        if filtered_df is None:
            logging.warning(f"Skipping {tech} due to errors in filtering")
            continue
            
        # Merge with configuration data
        merged_df = merge_with_config(tech)
        if merged_df is None:
            logging.warning(f"Skipping {tech} due to errors in merging")
    
    logging.info("===== Processing completed =====")
