import pandas as pd

file_path = '/media/colombres/DATOS/dev/alsina/plantilla_datos_nov25.xlsx'

try:
    xls = pd.ExcelFile(file_path)
    print("Sheet names:", xls.sheet_names)
    
    for sheet_name in xls.sheet_names:
        print(f"\n--- Sheet: {sheet_name} ---")
        df = pd.read_excel(xls, sheet_name=sheet_name, nrows=5)
        print(df.to_string())
        print("\nColumns:", df.columns.tolist())
except Exception as e:
    print(f"Error reading excel: {e}")
