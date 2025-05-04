import pandas as pd

# -------------------------------
# PART 1: Filter the main 2G data from the site database
# -------------------------------
def filter_main_file_2G():
    # Read the Excel file containing all sites
    df = pd.read_excel('All Site Follow Up V2.0.xlsx', sheet_name='2G Sites')
    
    # Debug: Print available columns from the main file
    print("Available columns in the main file:")
    print(df.columns.tolist())
    
    # Define the required columns for the output from the master file.
    # (Note: Excluding 'LAC' because we will fill that from the configuration file.)
    required_columns = [
        'Site code', 'Band', 'Site Status', 'BTS Type', 'BSC',
        'Site On Air Date', '900 Actual RBS Type', '900 On Air Date',
        '1800 Actual RBS Type', '1800 On Air Date', 'Notes', 'Real BSC',
        'Restoration date'
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
            # For "RESTORATION_DATE", try to match a variant with a space
            if req_upper == "Restoration date":
                found = False
                for key, orig in available_cols_dict.items():
                    if key.replace("_", " ") == "Restoration date":  # e.g. "Restoration date"
                        actual_required_columns.append(orig)
                        # Rename the column in df to standardize the output
                        df.rename(columns={orig: "Restoration date"}, inplace=True)
                        found = True
                        break
                if not found:
                    missing.append(req)
            else:
                missing.append(req)
    
    if missing:
        print("The following required columns are missing from the main file for 2G:", missing)
        return None
    else:
        # Use the key column 'Site code' (using our dictionary) to filter rows where it is not null.
        key_col = available_cols_dict['SITE CODE']
        condition = df[key_col].notnull()
        filtered = df.loc[condition, actual_required_columns]
        
        # Save the filtered 2G data (without LAC) to a new Excel file
        filtered.to_excel('excel2_2G.xlsx', index=False)
        print("Filtered 2G data saved to 'excel2_2G.xlsx'.")
        return filtered

# -------------------------------
# PART 2: Merge with the 2G cell configuration data (VLOOKUP-like)
# -------------------------------
def merge_with_config_2G():
    # Read the filtered 2G data
    df_result = pd.read_excel('excel2_2G.xlsx')
    
    # Read the cell configuration file from the '2G Cell Data' sheet
    df_config = pd.read_excel('Cell Configuration 2G.xlsm', sheet_name='2G Cell Data')
    
    # check if there is doublecate data
    df_result = df_result.drop_duplicates(subset=['Site code'])
    df_config = df_config.drop_duplicates(subset=['Site Code'])    
    print("Available columns in the 2G config file:")
    print(df_config.columns.tolist())
    
    # (Optional) Remove the 'LAC' column from df_result if it exists.
    if 'LAC' in df_result.columns:
        df_result = df_result.drop(columns=['LAC'])
    
    # Ensure the key for merging, 'Site code', is present in the configuration file.
    if 'Site code' not in df_config.columns:
        if 'Site Code' in df_config.columns:
            df_config.rename(columns={'Site Code': 'Site code'}, inplace=True)
            print("Renamed 'Site Code' to 'Site code' in the 2G config file.")
        else:
            print("Error: 'Site code' column not found in the 2G configuration file.")
            return None
    
    # Merge the filtered 2G data with the configuration data on 'Site code'.
    # This is analogous to an Excel VLOOKUP that populates the LAC column.
    merged = pd.merge(
        df_result,
        df_config[['Site code', 'LAC']],
        on='Site code',
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
    filtered_df = filter_main_file_2G()
    if filtered_df is not None:
        merge_with_config_2G()
