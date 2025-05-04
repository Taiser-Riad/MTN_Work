import pandas as pd
from datetime import datetime

# Read each Excel file into a DataFrame.
df_2g = pd.read_excel('excel_final_2G.xlsx')
df_3g = pd.read_excel('excel_final_3G.xlsx')
df_4g = pd.read_excel('excel_final_4G.xlsx')

df_2gc = pd.read_excel('excel_final_2G_Cells.xlsx')
df_3gc = pd.read_excel('excel_final_3G_Cells.xlsx')
df_4gc = pd.read_excel('excel_final_4G_Cells.xlsx')

# Generate timestamp string in MM-DD-YYYY format.
timestamp = datetime.now().strftime('%m-%d-%Y')
output_filename = f'merged_sites_{timestamp}.xlsx'

# Create an ExcelWriter object to write multiple sheets into the output file.
with pd.ExcelWriter(output_filename) as writer:
    df_2g.to_excel(writer, sheet_name='2G Sites', index=False)
    df_3g.to_excel(writer, sheet_name='3G Sites', index=False)
    df_4g.to_excel(writer, sheet_name='4G Sites', index=False)
    df_2gc.to_excel(writer, sheet_name='2G Cells', index=False)
    df_3gc.to_excel(writer, sheet_name='3G Cells', index=False)
    df_4gc.to_excel(writer, sheet_name='4G Cells', index=False)
print(f"Files merged into '{output_filename}' with sheets Cells & Sites '2G', '3G', and '4G'.")
