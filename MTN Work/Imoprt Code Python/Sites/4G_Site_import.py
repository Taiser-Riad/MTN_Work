import pandas as pd

# -------------------------------
# PART 1: Filter the main site database file
# -------------------------------
def filter_main_file():
    # Read the Excel file from the sheet 'LTE Sites'
    df = pd.read_excel('All Site Follow Up V2.0.xlsx', sheet_name='LTE Sites')
    
    # Debug: Print available columns
    print("Available columns in main file:", df.columns.tolist())

    # Define the required columns (adjust as necessary)
    required_columns = [
        'Site code', 'eNodeB ID', 'BTS Type', 
        'Status', 'Activation Date', 'Note', 
        'Restoration Date', 'Radio Plan'
    ]
    
    # Check if any required columns are missing
    missing_columns = [col for col in required_columns if col not in df.columns]
    if missing_columns:
        print(f"The following columns are missing in the main file: {missing_columns}")
        return None
    else:
        # Filter rows where 'Site code' is not null
        condition = df['Site code'].notnull()
        result = df.loc[condition, required_columns]
        
        # Save the filtered DataFrame to a new Excel file
        result.to_excel('excel2_4G.xlsx', index=False)
        print("Filtered data saved to 'excel2.xlsx'.")
        return result

# -------------------------------
# PART 2: Merge with cell configuration data (VLOOKUP-like)
# -------------------------------
def merge_with_config():
    # Read the filtered data from excel4G.xlsx
    df_result = pd.read_excel('excel2_4G.xlsx')
    
    # Read the cell configuration file from the specific sheet
    df_config = pd.read_excel('Cell Configuration LTE.xlsx', sheet_name='4G Cell Data')
    
    # check if there is doublicate data
    df_result = df_result.drop_duplicates(subset=['Site code'])
    df_config = df_config.drop_duplicates(subset=['Site code']) 
    
    # Debug: Print available columns in the configuration file
    print("Available columns in the config file:", df_config.columns.tolist())
    
    # Optional: If a column like 'TAC' already exists in df_result, drop it so that it gets replaced
    if 'TAC' in df_result.columns:
        df_result = df_result.drop(columns=['TAC'])
    
    # Ensure the key 'Site code' exists in both DataFrames before merging
    if 'Site code' not in df_config.columns:
        print("Error: 'Site code' column not found in the configuration file.")
        return None
    
    # Merge df_result with df_config on 'Site code' to bring in the 'TAC' column
    merged_df = pd.merge(
        df_result,
        df_config[['Site code', 'TAC']],   # Adjust this if the column name differs in df_config
        on='Site code',
        how='left'
    )
    
    # Save the merged DataFrame to a new Excel file
    merged_df.to_excel('excel_final_4G.xlsx', index=False)
    print("Data merged successfully. Check 'excel_final.xlsx' for the updated data.")

# -------------------------------
# Main execution flow
# -------------------------------
if __name__ == '__main__':
    filtered_df = filter_main_file()  # Step 1: Filter the main file
    if filtered_df is not None:
        merge_with_config()              # Step 2: Merge with configuration data (VLOOKUP simulation)

