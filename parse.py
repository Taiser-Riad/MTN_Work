import pandas as pd

df = pd.read_excel('MTN Power dataBase 2025 v7.0.xlsx')
df.columns = [col.strip().upper().replace(' ', '_') for col in df.columns]  # Normalize column names

def normalize_gen_names(value):
    if isinstance(value, str):
        value = value.lower()
        if 'mtn' in value:
            return 'MTN'
        elif 'ste' in value:
            return 'STE'
    return value

df['MTN_GEN'] = df['MTN_GEN'].apply(normalize_gen_names)
df['STE_GEN'] = df['STE_GEN'].apply(normalize_gen_names)

has_mtn_gen = df['MTN_GEN'].notna()
has_ste_gen = df['STE_GEN'].notna()
has_both = has_mtn_gen & has_ste_gen8

count_mtn = has_mtn_gen.sum()
count_ste = has_ste_gen.sum()
count_both = has_both.sum()

good_condition = df[df['GENERATOR_STATUS'].str.contains('Good', na=False)].shape[0]
needs_maintenance = df[df['GENERATOR_STATUS'].str.contains('Replace|Overhaul', na=False)].shape[0]

battery_columns = ['G1_GEL_BATT', 'G1_LITHIUM_BATT', 'G2_GEL_BATT', 'G2_LITHIUM_BATT']
common_types = df[battery_columns].apply(lambda col: col.notna().sum())
df['TOTAL_BATTERY_CAPACITY'] = df[battery_columns].sum(axis=1)


two_groups = df[(df['G1_GEL_BATT'].notna() | df['G1_LITHIUM_BATT'].notna()) & 
                (df['G2_GEL_BATT'].notna() | df['G2_LITHIUM_BATT'].notna())].shape[0]

solar_sites = df[df['SOLAR_PANEL'].notna()].shape[0]

on_air = df[df['STATUS'].str.contains('On Air', na=False)].shape[0]
stopped = df[df['STATUS'].str.contains('Stopped', na=False)].shape[0]

dimensions_data = df['DIMENSIONS'].dropna()

hybrid_sites = df[df['POWER_SOURCE_UPDATED'].str.contains('Hybrid', case=False, na=False)].shape[0]


df.to_excel('Parsed_MTNSites_Output.xlsx', index=False)
# Use an ORM or `sqlalchemy` to insert into your database
