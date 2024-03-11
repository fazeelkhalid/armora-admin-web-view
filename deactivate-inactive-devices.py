import requests

base_url = "https://app.armora.co.uk"
route_path = "/deactivate-inactive-devices"

url = base_url + route_path

try:
    response = requests.get(url)
    response.raise_for_status()  # Raise an HTTPError for bad responses

    # Print the response content or any other handling you may need
    print("Response:", response.text)

except requests.exceptions.RequestException as e:
    print("Error:", e)
