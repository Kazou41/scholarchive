import os

def count_words(filepath):
    with open(filepath, 'r', encoding='utf-8') as f:
        text = f.read()
    words = text.split()
    print(f"  {os.path.basename(filepath)}: {len(words)} kata, {len(text)} karakter")
    return len(words)

base = r'C:\Users\ACER\.gemini\antigravity\brain\bba7a1b9-ac77-4b7c-9140-c5eebf5f9524\artifacts'
files = [
    os.path.join(base, 'bab2_ringkas_bagian1.md'),
    os.path.join(base, 'bab2_ringkas_bagian2.md'),
    os.path.join(base, 'bab2_ringkas_bagian3.md'),
]

total = 0
print("=== Hasil Ringkasan BAB II ===")
for f in files:
    total += count_words(f)
print(f"\n  TOTAL: {total} kata")
print(f"\n  Target: ~6,300-6,500 kata (setara Aggata)")
print(f"  Asli Alzazo: ~12,410 kata")
print(f"  Persentase pengurangan: {((12410-total)/12410)*100:.1f}%")
