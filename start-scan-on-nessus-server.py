import requests
import time
import random

def send_get_request():
    url = "https://app.armora.co.uk/start-scan-on-nessus-server"

    try:
        response = requests.get(url)
        # You can handle the response as needed, e.g., check for success status codes
        if response.status_code == 200:
            print("GET request successful")
        else:
            print(f"GET request failed with status code: {response.status_code}")

    except Exception as e:
        print(f"An error occurred: {e}")

def main():
    # Generate a random delay between 30 seconds and 2 minutes
    random_delay = random.uniform(30, 120)
    
    print(f"Waiting for {random_delay:.2f} seconds before sending the GET request...")
    time.sleep(random_delay)

    # Send the GET request
    send_get_request()

if __name__ == "__main__":
    while (True):
        main()
