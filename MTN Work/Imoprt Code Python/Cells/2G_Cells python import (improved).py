import pandas as pd
import logging
import sys

# Configure logging
logging.basicConfig(
    level=logging.INFO,
    format='%(asctime)s %(levelname)s: %(message)s',
    handlers=[
        logging.FileHandler("merge_all_tech_daily.log"),
        logging.StreamHandler(sys.stdout)
    ]
)

# Technology configuration settings
TECH_CONFIG = {
    '2G': {
        'config_file': 'Cell Configuration 2G.xlsm',
        'config_sheet': '2G Cell Data',
        'skiprows': 0,
        'config_columns': [
            'CELL ID', 'CELL CODE', 'CELL NAME', 'ON AIR DATE',
            'SERVING AREA IN ENGLISH', 'SERVING AREA', 'NOTE', 'BSC'
        ],
        'hw_columns': [
            'CELL ID', 'AZIMUTH', 'HEIGHT', 'M_TILT', 'E_TILT',
            'TOTAL_TILT', 'CGI', 'CGI HEX', 'BSIC'
        ]
    },
    '3G': {
        'config_file': 'Cell Configuration 3G.xlsx',
        'config_sheet': 'Details',
        'skiprows': 1,
        'config_columns': [
            'CELL ID', 'CELL CODE', 'CELL NAME', 'ON AIR DATE',
            'SERVING AREA IN ENGLISH', 'SERVING AREA', 'NOTE', 'Carrier'
        ],
        'hw_columns': [
            'CELL ID', 'AZIMUTH', 'HEIGHT', 'M_TILT', 'E_TILT',
            'TOTAL_TILT', 'CGI', 'CGI HEX'
        ]
    },
    '4G': {
        'config_file': 'Cell Configuration LTE.xlsx',
        'config_sheet': '4G Cell Data',
        'skiprows': 0,
        'config_columns': [
            'CELL ID', 'CELL CODE', 'CELL NAME', 'ON AIR DATE',
            'SERVING AREA IN ENGLISH', 'SERVING AREA', 'NOTE'
        ],
        'hw_columns': [
            'CELL ID', 'AZIMUTH', 'HEIGHT', 'M_TILT', 'E_TILT',
            'TOTAL_TILT', 'CGI', 'CGI HEX'
        ]
    },
    '5G': {
        'config_file': 'Cell Configuration 5G.xlsx',
        'config_sheet': '5G Cell Data',
        'skiprows': 0,
        'config_columns': [
            'CELL ID', 'CELL CODE', 'CELL NAME', 'ON AIR DATE',
            'SERVING AREA IN ENGLISH', 'SERVING AREA', 'NOTE'
        ],
        'hw_columns': [
            'CELL ID', 'AZIMUTH', 'HEIGHT', 'M_TILT', 'E_TILT',
            'TOTAL_TILT', 'CGI', 'CGI HEX'
        ]
    }
}

def filter_config(tech):
    """
    Reads and filters configuration data for the specified technology.
    Ensures required columns are present and CELL ID is not null.
    Saves filtered data to an intermediate Excel file.
    """
    config = TECH_CONFIG[tech]
    try:
        # Read configuration file with technology-specific settings
        df = pd.read_excel(
            config['config_file'],
            sheet_name=config['config_sheet'],
            skiprows=config['skiprows']
        )
        logging.info(f"Successfully read {tech} configuration file")
    except Exception as e:
        logging.error(f"Failed to read {tech} configuration file: {e}")
        return None

    # Log available columns for debugging
    logging.info(f"Available columns in {tech} configuration file:")
    logging.info(df.columns.tolist())

    # Map available columns to normalized names (uppercase, stripped)
    available_cols_dict = {col.strip().upper(): col for col in df.columns}
    
    # Find matching columns for required configuration columns
    actual_required_columns = []
    missing = []
    for req in config['config_columns']:
        req_upper = req.strip().upper()
        if req_upper in available_cols_dict:
            actual_required_columns.append(available_cols_dict[req_upper])
        else:
            missing.append(req)

    if missing:
        logging.error(
            f"The following required columns are missing from {tech} configuration: {missing}"
        )
        return None

    # Filter rows where CELL ID is not null
    key_col = available_cols_dict['CELL ID']
    condition = df[key_col].notnull()
    filtered = df.loc[condition, actual_required_columns]
    
    # Save filtered data to intermediate file
    output_file = f'excel2_{tech}_Cells_config.xlsx'
    try:
        filtered.to_excel(output_file, index=False)
        logging.info(f"Filtered {tech} configuration saved to '{output_file}'")
    except Exception as e:
        logging.error(f"Failed to save filtered {tech} configuration: {e}")
        return None

    return filtered

def merge_with_hw(tech, hw_db):
    """
    Merges filtered configuration data with HW database for the specified technology.
    Uses preprocessed HW database for efficiency.
    """
    config = TECH_CONFIG[tech]
    input_file = f'excel2_{tech}_Cells_config.xlsx'
    
    try:
        df_config = pd.read_excel(input_file)
        logging.info(f"Loaded filtered {tech} configuration from '{input_file}'")
    except Exception as e:
        logging.error(f"Failed to read filtered {tech} configuration: {e}")
        return None

    # Check for required HW columns
    missing_hw_cols = [col for col in config['hw_columns'] if col not in hw_db.columns]
    if missing_hw_cols:
        logging.error(
            f"Missing required columns in HW DB for {tech}: {missing_hw_cols}"
        )
        return None

    # Remove duplicates before merging
    df_config = df_config.drop_duplicates(subset=['CELL ID'])
    hw_sub = hw_db[config['hw_columns']].copy()
    hw_sub = hw_sub.drop_duplicates(subset=['CELL ID'])

    # Perform the merge
    try:
        merged = pd.merge(
            df_config,
            hw_sub,
            on='CELL ID',
            how='left'
        )
        logging.info(f"Successfully merged {tech} data with HW database")
    except Exception as e:
        logging.error(f"Failed to merge {tech} data: {e}")
        return None

    # Save final merged data
    output_file = f'excel_final_{tech}_Cells.xlsx'
    try:
        merged.to_excel(output_file, index=False)
        logging.info(f"Merged {tech} data saved to '{output_file}'")
    except Exception as e:
        logging.error(f"Failed to save merged {tech} data: {e}")
        return None

    return merged

def preprocess_hw_db(hw_file='HW DB 30-6-2025.xlsx', hw_sheet='Data'):
    """
    Preprocesses the HW database by standardizing column names
    and ensuring consistent formatting.
    """
    try:
        hw_db = pd.read_excel(hw_file, sheet_name=hw_sheet)
        logging.info("Successfully loaded HW database")
    except Exception as e:
        logging.error(f"Failed to read HW DB file: {e}")
        return None

    # Standardize column names (strip whitespace)
    hw_db.columns = [col.strip() for col in hw_db.columns]
    
    # Handle 'CELL ID' column naming variations
    if 'Cell ID' in hw_db.columns and 'CELL ID' not in hw_db.columns:
        hw_db.rename(columns={'Cell ID': 'CELL ID'}, inplace=True)
        logging.info("Renamed 'Cell ID' to 'CELL ID' in HW database")

    # Check if CELL ID exists after standardization
    if 'CELL ID' not in hw_db.columns:
        logging.error("'CELL ID' column not found in HW database after standardization")
        return None

    logging.info("HW database preprocessing completed")
    return hw_db

if __name__ == '__main__':
    logging.info("===== Starting network data processing =====")
    
    # Preprocess HW database once for efficiency
    hw_db = preprocess_hw_db()
    if hw_db is None:
        logging.error("HW database preprocessing failed. Exiting.")
        sys.exit(1)
    
    # Process all technologies
    for tech in ['2G', '3G', '4G',]:
        logging.info(f"===== Processing {tech} data =====")
        
        # Filter configuration data
        filtered_df = filter_config(tech)
        if filtered_df is None:
            logging.warning(f"Skipping {tech} due to configuration errors")
            continue
            
        # Merge with HW database
        merged_df = merge_with_hw(tech, hw_db)
        if merged_df is None:
            logging.warning(f"{tech} merge with HW database failed")
    
    logging.info("===== Processing completed =====")
