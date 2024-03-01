import requests
import time
import random
import datetime

# Function to get current date and time in the desired format
def get_timestamp():
    return datetime.datetime.now().strftime("%Y-%m-%d %H:%M:%S")

# Function to write output to file with timestamp
def dump_to_file(output):
    timestamp = get_timestamp()
    with open("merged-program-output.txt", "a") as file:
        file.write(f"{timestamp} {output}\n")

def send_get_request(url, task_name):
    try:
        response = requests.get(url)
        # You can handle the response as needed, e.g., check for success status codes
        if response.status_code == 200:
            print(f"{task_name} successful - Status Code: {response.status_code} - Response: {response.text}")
            dump_to_file(f"{task_name} successful - Status Code: {response.status_code} - Response: {response.text}")
        else:
            print(f"{task_name} failed with status code: {response.status_code} - Response: {response.text}")
            dump_to_file(f"{task_name} failed with status code: {response.status_code} - Response: {response.text}")

    except Exception as e:
        print(f"An error occurred: {e}")
        dump_to_file(f"An error occurred: {e}")


def main():
    # baseURL= "https://app.armora.co.uk"
    baseURL= "http://127.0.0.1:8000"
    
    while True:
        # Alternating between two URLs
        send_get_request(baseURL + "/start-scan-on-nessus-server", "Scan on Nessus Server")
        
        random_delay = random.uniform(30, 120)        
        print(f"Waiting for {random_delay:.2f} seconds before the next iteration...")
        dump_to_file(f"Waiting for {random_delay:.2f} seconds before the next iteration...")
        send_get_request(baseURL + "/dump-nessus-data", "Dump Nessus Data")

        # Generate a random delay between 30 seconds and 2 minutes
        random_delay = random.uniform(30, 120)
        print(f"Waiting for {random_delay:.2f} seconds before the next iteration...")
        dump_to_file(f"Waiting for {random_delay:.2f} seconds before the next iteration...")
        time.sleep(random_delay)

if __name__ == "__main__":
    main()
