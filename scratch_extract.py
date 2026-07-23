import zipfile
import xml.etree.ElementTree as ET
import sys
import re

def extract_text_from_docx(docx_path):
    try:
        with zipfile.ZipFile(docx_path) as docx:
            xml_content = docx.read('word/document.xml')
            tree = ET.XML(xml_content)
            
            # The XML namespace for Word
            WORD_NAMESPACE = '{http://schemas.openxmlformats.org/wordprocessingml/2006/main}'
            PARA = WORD_NAMESPACE + 'p'
            TEXT = WORD_NAMESPACE + 't'
            
            paragraphs = []
            for paragraph in tree.iter(PARA):
                texts = [node.text for node in paragraph.iter(TEXT) if node.text]
                if texts:
                    paragraphs.append(''.join(texts))
            
            text = '\n'.join(paragraphs)
            
            # extract first 2000 chars to test
            # print(text[:2000])
            
            # Write to a txt file to easily read with view_file
            out_path = 'd:/KULIAH/Semester 8/BISMILLAH/skolarcip/refrensi skripsi zazo/draft_skripsi_alzazo_extracted.txt'
            with open(out_path, 'w', encoding='utf-8') as f:
                f.write(text)
            print("Extracted to:", out_path)
    except Exception as e:
        print("Error:", e)

if __name__ == '__main__':
    extract_text_from_docx(r'd:\KULIAH\Semester 8\BISMILLAH\skolarcip\refrensi skripsi zazo\22520244021_Alzazo Khozetama_Draft Skripsi FIX.docx')
