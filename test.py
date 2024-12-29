import os
import requests

def send_get_requests_recursive(folder_path, base_url, output_file="responses.md"):
  """
  Sends GET requests to all PHP files in a folder and its subdirectories,
  recording results into a Markdown file.
  
  Args:
    folder_path (str): Path to the folder containing PHP files.
    base_url (str): The base URL to send requests to (e.g., http://localhost/).
    output_file (str): Path to the output Markdown file.
  """
  if not os.path.isdir(folder_path):
    print(f"The folder path '{folder_path}' does not exist.")
    return

  # Open the Markdown file for writing
  with open(output_file, "w") as md_file:
    md_file.write("# GET Request Responses\n\n")
    md_file.write("| File Path | URL | Status Code | Response Text |\n")
    md_file.write("|-----------|-----|-------------|---------------|\n")

    # Walk through the folder recursively
    for root, _, files in os.walk(folder_path):
      for file in files:
        if file.endswith(".php"):
          file_path = os.path.relpath(os.path.join(root, file), folder_path)
          file_url = os.path.join(base_url, file_path).replace("\\", "/")  # Normalize URL
          try:
            response = requests.get(file_url)
            status_code = response.status_code
            response_text = response.text.strip()[:100].replace('\n', ' ') + "..." if len(response.text.strip()) > 100 else response.text.strip()
            print(f"GET {file_url} - Status Code: {status_code}")

            # Write the result to the Markdown file
            md_file.write(f"| `{file_path}` | `{file_url}` | {status_code} | `{response_text}` |\n")
          except requests.exceptions.RequestException as e:
            print(f"Error sending GET request to {file_url}: {e}")
            md_file.write(f"| `{file_path}` | `{file_url}` | ERROR | `{str(e)}` |\n")

# Example usage
folder_path = "./deviceAPIs"  # Replace with your folder path
base_url = "http://localhost:8000/deviceAPIs"  # Replace with the base URL for the server
send_get_requests_recursive(folder_path, base_url)
