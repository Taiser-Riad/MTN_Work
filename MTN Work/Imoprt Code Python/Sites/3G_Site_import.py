import pandas as pd

# -------------------------------
# PART 1: Filter the main 3G data from the site database
# -------------------------------
def filter_main_file_3G():
    # Read the master file from the "3G Sites" sheet
    df = pd.read_excel('All Site Follow Up V2.0.xlsx', sheet_name='3G Sites')
    
    # Print available columns for debugging
    print("Available columns in the main 3G file:")
    print(df.columns.tolist())
    
    # Define the required columns in the desired order.
    # Note: We omit 'Real RNC' here if we expect to update it from the configuration file.
    required_columns = [
        'Site code', 'WBTS ID', 'RNC', 'Site Status', 'On Air Date',
        'Renovation Date', 'Actual  Type', 'Number of Carriers',
        'E1 Actual', 'Notes', 'Real RNC', 'Restoration Date'
    ]
    
    # Create a mapping of uppercase stripped names to the original names
    available_cols_dict = {col.strip().upper(): col for col in df.columns}
    
    actual_required_columns = []
    missing = []
    for req in required_columns:
        req_upper = req.strip().upper()
        if req_upper in available_cols_dict:
            actual_required_columns.append(available_cols_dict[req_upper])
        else:
            # For columns like "Restoration Date" we try to match common variants.
            if req_upper == "RESTORATION DATE":
                found = False
                for key, orig in available_cols_dict.items():
                    if key.replace("_", " ") == "RESTORATION DATE":
                        actual_required_columns.append(orig)
                        # Standardize by renaming in df
                        df.rename(columns={orig: "Restoration Date"}, inplace=True)
                        found = True
                        break
                if not found:
                    missing.append(req)
            else:
                missing.append(req)
    
    if missing:
        print("The following required columns are missing from the main 3G file:", missing)
        return None
    else:
        # Use the key column "Site Code" (look it up in the mapping).
        key_col = available_cols_dict['SITE CODE']
        condition = df[key_col].notnull()
        filtered = df.loc[condition, actual_required_columns]
        
        # Optionally, you can drop the "LAC" column now so that it will be replaced from the config file.
        if 'LAC' in filtered.columns:
            filtered = filtered.drop(columns=['LAC'])
        
        # Save the filtered 3G data to a new Excel file.
        filtered.to_excel('excel2_3G.xlsx', index=False)
        print("Filtered 3G data saved to 'excel2_3G.xlsx'.")
        return filtered

# -------------------------------
# PART 2: Merge with the 3G cell configuration data (VLOOKUP-like)
# -------------------------------
def merge_with_config_3G():
    # Read the filtered 3G data
    df_result = pd.read_excel('excel2_3G.xlsx')
    
    # Read the configuration file from 'Cell Configuration 3G.xlsx' and sheet 'Details'
    df_config = pd.read_excel('Cell Configuration 3G.xlsx', sheet_name='Details', header=1)
    
    # check if there is doublecate data
    df_result = df_result.drop_duplicates(subset=['Site Code'])
    df_config = df_config.drop_duplicates(subset=['Site Code']) 
    
    print("Available columns in the 3G configuration file:")
    print(df_config.columns.tolist())
    
    # We assume that the configuration file is expected to provide the correct "LAC" values.
    # If the filtered data already contains a "LAC" column, we drop it so it gets replaced.
    if 'LAC' in df_result.columns:
        df_result = df_result.drop(columns=['LAC'])
    
    # Ensure that the merge key exists in the configuration file.
    if 'Site Code' not in df_config.columns:
        if 'Site code' in df_config.columns:
            df_config.rename(columns={'Site code': 'Site Code'}, inplace=True)
            print("Renamed 'Site code' to 'Site Code' in the configuration file.")
        else:
            print("Error: 'Site Code' column not found in the configuration file.")
            return None
    
    # Merge the filtered 3G data with the configuration data on "Site Code".
    # We assume that the configuration file has the columns "Site Code" and "LAC".
    merged_df = pd.merge(
        df_result,
        df_config[['Site Code', 'LAC']],
        on='Site Code',
        how='left'
    )
    
    # Save the final merged DataFrame to a new Excel file.
    merged_df.to_excel('excel_final_3G.xlsx', index=False)
    print("3G data merged successfully. Check 'excel_final_3G.xlsx'.")
    return merged_df

# -------------------------------
# Main execution flow
# -------------------------------
if __name__ == '__main__':
    filtered_df = filter_main_file_3G()
    if filtered_df is not None:
        merge_with_config_3G()
