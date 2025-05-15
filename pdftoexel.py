import PyPDF2
import pandas as pd

def extract_text_from_pdf(pdf_path):
    text = ""
    with open(pdf_path, "rb") as f:
        reader = PyPDF2.PdfReader(f)
        num_pages = len(reader.pages)
        for page_number in range(num_pages):
            page = reader.pages[page_number]
            text += page.extract_text()
    return text

def save_to_excel(text, excel_path):
    lines = text.split('\n')
    data = []
    for line in lines:
        parts = line.split()
        if len(parts) > 2:
            first_word = parts[0]
            second_word = parts[1]
            middle_text = ' '.join(parts[2:-1])
            last_word = parts[-1]
            data.append([first_word, second_word, middle_text, last_word])
    df = pd.DataFrame(data, columns=["Primera Palabra", "Segunda Palabra", "Texto Intermedio", "Ultima Palabra"])
    df.to_excel(excel_path, index=False)

if __name__ == "__main__":
    pdf_path = "cata.pdf"
    excel_path = "resultado.xlsx"

    text = extract_text_from_pdf(pdf_path)
    save_to_excel(text, excel_path)
