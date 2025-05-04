import pandas as pd

# -------------------------------
# PART 1: Filter the 2G configuration data
# -------------------------------
def filter_config_2G():
    # Read the Excel file with the 2G configuration data
    df = pd.read_excel('Cell Configuration 2G.xlsm', sheet_name='2G Cell Data')
    
    # Debug: Print available columns from the configuration file
    print("Available columns in the 2G configuration file:")
    print(df.columns.tolist())
    
    # Define the required columns from the 2G configuration file.
    # Note: We use the names as given below.
    required_columns = [
        'CELL ID', 'CELL CODE', 'CELL NAME', 'ON AIR DATE',
        'SERVING AREA IN ENGLISH', 'SERVING AREA', 'NOTE' , 'BSC' 
    ]
    
    # Create a dictionary mapping uppercase stripped column names to the original names.
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
        print("The following required columns are missing from the 2G configuration file:", missing)
        return None
    else:
        # Use the key column 'CELL ID' to filter rows where it is not null.
        key_col = available_cols_dict['CELL ID']
        condition = df[key_col].notnull()
        filtered = df.loc[condition, actual_required_columns]
        
        # Save the filtered 2G configuration data to a new Excel file.
        filtered.to_excel('excel2_2G_config.xlsx', index=False)
        print("Filtered 2G configuration data saved to 'excel2_2G_config.xlsx'.")
        return filtered

# -------------------------------
# PART 2: Merge with the 2G HW DB data (VLOOKUP-like)
# -------------------------------
def merge_with_hw_2G():
    # Read the filtered 2G configuration data.
    df_config = pd.read_excel('excel2_2G_config.xlsx')
    
    # Read the HW DB file for 2G data from the specified sheet.
    df_hw = pd.read_excel('HW DB 21-4-2025.xlsx', sheet_name='Data')
    
    # Standardize column names by stripping extra spaces in both DataFrames.
    df_config.columns = df_config.columns.str.strip()
    df_hw.columns = df_hw.columns.str.strip()
    
    print("Available columns in the HW DB file for 2G:")
    print(df_hw.columns.tolist())
    
    # Ensure the key column 'CELL ID' exists in the HW DB DataFrame.
    if 'CELL ID' not in df_hw.columns:
        if 'Cell ID' in df_hw.columns:
            df_hw.rename(columns={'Cell ID': 'CELL ID'}, inplace=True)
            print("Renamed 'Cell ID' to 'CELL ID' in the HW DB file.")
        else:
            print("Error: 'CELL ID' column not found in the HW DB file.")
            return None
        
    # Remove duplicate CELL ID rows from both DataFrames before merging
    df_config = df_config.drop_duplicates(subset=['CELL ID'])
    df_hw = df_hw.drop_duplicates(subset=['CELL ID'])
    
    # Define the required columns from the HW DB file. (DON'T FORGET TO ADD CARRIER)
    required_hw_columns = [
        'CELL ID', 'AZIMUTH', 'HEIGHT', 'M_TILT',
        'E_TILT', 'TOTAL_TILT', 'CGI', 'CGI HEX' , 'BSIC' 

    ]
    
    # Merge the configuration data with the HW DB data on 'CELL ID'.
    # This acts like an Excel VLOOKUP.
    merged = pd.merge(
        df_config,
        df_hw[required_hw_columns],
        on='CELL ID',
        how='left'
    )
    
    # Save the final merged DataFrame to a new Excel file.
    merged.to_excel('excel_final_2G.xlsx', index=False)
    print("2G data merged successfully. Check 'excel_final_2G.xlsx'.")
    return merged

# -------------------------------
# Main execution flow
# -------------------------------
if __name__ == '__main__':
    filtered_df = filter_config_2G()
    if filtered_df is not None:
        merge_with_hw_2G()
