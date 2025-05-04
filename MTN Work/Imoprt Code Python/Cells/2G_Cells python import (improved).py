
import pandas as pd
import logging
import sys

logging.basicConfig(
    level=logging.INFO,
    format='%(asctime)s %(levelname)s: %(message)s',
    handlers=[
        logging.FileHandler("merge_2g_daily.log"),
        logging.StreamHandler(sys.stdout)
    ]
)

def filter_config_2G(config_file='Cell Configuration 2G.xlsm', sheet_name='2G Cell Data', output_file='excel2_2G_Cells_config.xlsx'):
    """
    Reads and filters the 2G configuration data, ensuring required columns are present and CELL ID is not null.
    Saves the filtered data to an Excel file.
    Returns the filtered DataFrame or None if errors occur.
    """
    try:
        df = pd.read_excel(config_file, sheet_name=sheet_name)
    except Exception as e:
        logging.error(f"Failed to read configuration file: {e}")
        return None

    logging.info("Available columns in the 2G configuration file:")
    logging.info(df.columns.tolist())

    required_columns = [
        'CELL ID', 'CELL CODE', 'CELL NAME', 'ON AIR DATE',
        'SERVING AREA IN ENGLISH', 'SERVING AREA', 'NOTE', 'BSC'
    ]

    available_cols_dict = {col.strip().upper(): col for col in df.columns}
    actual_required_columns = []
    missing = []
    for req in required_columns:
        req_upper = req.strip().upper()
        if req_upper in available_cols_dict:
            actual_required_columns.append(available_cols_dict[req_upper])
        else:
            missing.append(req)

    if missing:
        logging.error(f"The following required columns are missing from the 2G configuration file: {missing}")
        return None

    key_col = available_cols_dict['CELL ID']
    condition = df[key_col].notnull()
    filtered = df.loc[condition, actual_required_columns]

    try:
        filtered.to_excel(output_file, index=False)
        logging.info(f"Filtered 2G configuration data saved to '{output_file}'.")
    except Exception as e:
        logging.error(f"Failed to save filtered configuration: {e}")
        return None

    return filtered

def merge_with_hw_2G(config_file='excel2_2G_Cells_config.xlsx', hw_file='HW DB 24-4-2025.xlsx', hw_sheet='Data', output_file='excel_final_2G_Cells.xlsx'):
    """
    Merges the filtered 2G configuration data with the HW DB data on 'CELL ID'.
    Drops duplicate CELL ID rows before merging.
    Saves the merged DataFrame to an Excel file.
    Returns the merged DataFrame or None if errors occur.
    """
    try:
        df_config = pd.read_excel(config_file)
    except Exception as e:
        logging.error(f"Failed to read filtered config file: {e}")
        return None

    try:
        df_hw = pd.read_excel(hw_file, sheet_name=hw_sheet)
    except Exception as e:
        logging.error(f"Failed to read HW DB file: {e}")
        return None

    df_config.columns = df_config.columns.str.strip()
    df_hw.columns = df_hw.columns.str.strip()

    logging.info("Available columns in the HW DB file for 2G:")
    logging.info(df_hw.columns.tolist())

    # Ensure the key column 'CELL ID' exists in the HW DB DataFrame.
    if 'CELL ID' not in df_hw.columns:
        if 'Cell ID' in df_hw.columns:
            df_hw.rename(columns={'Cell ID': 'CELL ID'}, inplace=True)
            logging.info("Renamed 'Cell ID' to 'CELL ID' in the HW DB file.")
        else:
            logging.error("Error: 'CELL ID' column not found in the HW DB file.")
            return None

    # Remove duplicate CELL ID rows from both DataFrames before merging
    df_config = df_config.drop_duplicates(subset=['CELL ID'])
    df_hw = df_hw.drop_duplicates(subset=['CELL ID'])

    required_hw_columns = [
        'CELL ID', 'AZIMUTH', 'HEIGHT', 'M_TILT',
        'E_TILT', 'TOTAL_TILT', 'CGI', 'CGI HEX', 'BSIC'
    ]

    # Check if all required HW columns exist
    missing_hw_cols = [col for col in required_hw_columns if col not in df_hw.columns]
    if missing_hw_cols:
        logging.error(f"The following required columns are missing from the HW DB file: {missing_hw_cols}")
        return None

    try:
        merged = pd.merge(
            df_config,
            df_hw[required_hw_columns],
            on='CELL ID',
            how='left'
        )
    except Exception as e:
        logging.error(f"Failed to merge DataFrames: {e}")
        return None

    try:
        merged.to_excel(output_file, index=False)
        logging.info(f"2G data merged successfully. Check '{output_file}'.")
    except Exception as e:
        logging.error(f"Failed to save merged data: {e}")
        return None

    return merged

if __name__ == '__main__':
    filtered_df = filter_config_2G()
    if filtered_df is not None:
        merge_with_hw_2G()
