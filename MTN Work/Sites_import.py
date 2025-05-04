import pandas as pd

# -------------------------------
# PART 1: Filter the main All Sites data from the site database
# -------------------------------
def filter_main_file_All_Sites():
    # Read the Excel file containing all sites
    df = pd.read_excel('All Site Follow Up V2.0.xlsx', sheet_name='2G Sites')
    
    # Debug: Print available columns from the main file
    print("Available columns in the main file:")
    print(df.columns.tolist())
    
    # Define the required columns for the output from the master file.
    # (Note: Excluding 'LAC' because we will fill that from the configuration file.)
    required_columns = [
        'Site code', 'Site Name', 'Zone', 'Province', 'C/R',
        'Supplier', 'BSC', 'Power Backup',
        'Site On Air Date', 'Relocation Date', 'Coordinates E', 'Coordinates N',
        'Site Adress' , 'Arabic Name', 'TX_Node', 'Technical Priority' ,
        'Administrative Area' , 'Node Category' , 'Site Ranking' , 'Subcontractor' ,
        'Invoice Type' ,
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
        print("The following required columns are missing from the main file for All Sites Sites:", missing)
        return None
    else:
        # Use the key column 'Site code' (using our dictionary) to filter rows where it is not null.
        key_col = available_cols_dict['SITE CODE']
        condition = df[key_col].notnull()
        filtered = df.loc[condition, actual_required_columns]
        
        # Save the filtered All Sites data (without LAC) to a new Excel file
        filtered.to_excel('excel2_All Sites.xlsx', index=False)
        print("Filtered All Sites data saved to 'excel2_All Sites.xlsx'.")
        return filtered

# -------------------------------
# PART 2: Merge with the All Sites data (VLOOKUP-like)
# -------------------------------
def merge_with_config_All_Sites():
    # Read the filtered All Sites data
    df_result = pd.read_excel('excel2_All Sites.xlsx')
    
    # Read the cell configuration file from the 'All Sites Cell Data' sheet
    df_config = pd.read_excel('HW DB 24-4-2025.xlsx', sheet_name='Data')
    
    # check if there is doublecate data
    df_result = df_result.drop_duplicates(subset=['Site code'])
    df_config = df_config.drop_duplicates(subset=['SITE_ID'])    
    print("Available columns in the All Sites config file:")
    print(df_config.columns.tolist())
    
    # (Optional) Remove the 'Altitude' column from df_result if it exists.
    if 'Altitude' in df_result.columns:
        df_result = df_result.drop(columns=['Altitude'])
    
    # Ensure the key for merging, 'Site code', is present in the configuration file.
    if 'SITE_ID' not in df_config.columns:
        if 'Site Code' in df_config.columns:
            df_config.rename(columns={'Site Code': 'Site code'}, inplace=True)
            print("Renamed 'Site Code' to 'Site code' in the All Sites config file.")
        else:
            print("Error: 'Site code' column not found in the All Sites configuration file.")
            return None
    
    # Merge the filtered All Sites data with the configuration data.
    # This is analogous to an Excel VLOOKUP that populates the Altitude column.
    merged = pd.merge(
        df_result,
        df_config[['SITE_ID', 'Altitude']],
        left_on='Site code',
        right_on='SITE_ID',
        how='left'
    )
    
    # Save the final merged DataFrame to a new Excel file.
    merged.to_excel('excel_final_All Sites.xlsx', index=False)
    print("All Sites data merged successfully. Check 'excel_final_All Sites.xlsx'.")
    return merged

# def check_missing_site_codes():
#     # Read Site codes from main 2G Sites sheet
#     df_2g = pd.read_excel('All Site Follow Up V2.0.xlsx', sheet_name='2G Sites')
#     site_codes_2g = set(df_2g['Site code'].dropna().astype(str).str.strip())
    
#     # Read Site_ID Location 2 sheet and filter for Tech == '3G'
#     df_3g = pd.read_excel('All Site Follow Up V2.0.xlsx', sheet_name='Site_ID Location 2')
#     df_3g_tech = df_3g[df_3g['Tech'].astype(str).str.strip() == '3G']
#     site_codes_3g = set(df_3g_tech['Site code'].dropna().astype(str).str.strip())
    
#     # Find Site codes in 2G Sites not present in 3G Tech sheet
#     missing_site_codes = site_codes_2g - site_codes_3g
    
#     if missing_site_codes:
#         print(f"Site codes in '2G Sites' missing from 'Site_ID Location 2' (Tech='3G'):")
#         for code in sorted(missing_site_codes):
#             print(code)
#     else:
#         print("All Site codes from '2G Sites' are present in 'Site_ID Location 2' (Tech='3G').")
    
#     return missing_site_codes


# -------------------------------
# Main execution flow
# -------------------------------
if __name__ == '__main__':
    filtered_df = filter_main_file_All_Sites()
    if filtered_df is not None:
        merge_with_config_All_Sites()
