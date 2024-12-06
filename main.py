# Specify your input and output file paths
input_file_path = 'input.txt'
output_file_path = 'output.txt'

with open(input_file_path, 'r', encoding='utf-8') as infile:
    lines = infile.read().splitlines()
    lines = set(lines)

with open(output_file_path, 'w', encoding='utf-8') as outfile:
    for line in sorted(lines):
        outfile.write(line + "\n")

print(f"Cleaned content has been written to {output_file_path}.")

