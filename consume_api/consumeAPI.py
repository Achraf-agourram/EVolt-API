import requests

BASE_URL = "http://127.0.0.1:8000/api"

def login(email, password):
    url = f"{BASE_URL}/login"

    data = {
        "email": email,
        "password": password
    }

    response = requests.post(url, json=data)

    print("\nLOGIN:", response.status_code)
    result = response.json()
    print(result)

    token = result.get("token")
    return token

TOKEN = login('achraf@gmail.com', 'password')


def register():
    url = f"{BASE_URL}/register"

    data = {
        "name": "Achraf",
        "email": "achraf@gmail.com",
        "password": "123456",
        "role": "admin"
    }

    response = requests.post(url, json=data)
    print("REGISTER:", response.status_code)
    print(response.json())

def logout():
    url = f"{BASE_URL}/logout"

    headers = {
        "Authorization": f"Bearer {TOKEN}"
    }

    response = requests.post(url, headers=headers)

    print("\nLOGOUT:", response.status_code)
    print(response.json())

def search_stations(city=None, location=None):
    
    params = {}
    headers = {
        "Authorization": f"Bearer {TOKEN}"
    }

    if city:
        params["city"] = city

    if location:
        params["location"] = location

    response = requests.get(f"{BASE_URL}/stations", headers=headers, params=params)

    print("STATUS:", response.status_code)

    try:
        data = response.json()
    except:
        print(response.status_code)
        return

    print("RESULT:")
    for station in data:
        print(station)

def book_station(station_id, start_time, end_time):
    
    url = f"{BASE_URL}/book"

    headers = {
        "Authorization": f"Bearer {TOKEN}",
        "Content-Type": "application/json"
    }

    data = {
        "station_id": station_id,
        "start_time": start_time,
        "end_time": end_time
    }

    response = requests.post(url, json=data, headers=headers)

    print("STATUS:", response.status_code)

    try:
        print(response.json())
    except:
        print(response.status_code)

def cancel_reservation(reservation_id):

    url = f"{BASE_URL}/reservations/{reservation_id}/cancel"

    headers = {
        "Authorization": f"Bearer {TOKEN}",
        "Content-Type": "application/json"
    }

    response = requests.patch(url, headers=headers)

    print("STATUS:", response.status_code)

    try:
        print(response.json())
    except:
        print(response.status_code)

def update_reservation(reservation_id, start_time, end_time):

    url = f"{BASE_URL}/reservations/{reservation_id}"

    headers = {
        "Authorization": f"Bearer {TOKEN}",
        "Content-Type": "application/json"
    }

    data = {
        "start_time": start_time,
        "end_time": end_time
    }

    response = requests.put(url, json=data, headers=headers)

    print("STATUS:", response.status_code)

    try:
        print(response.json())
    except:
        print(response.status_code)

def history():
    headers = {
        "Authorization": f"Bearer {TOKEN}"
    }

    response = requests.get(f"{BASE_URL}/history", headers=headers)

    print("STATUS:", response.status_code)

    try:
        data = response.json()
    except:
        print(response.status_code)
        return

    print("RESULT:")
    for session in data:
        print(session)

def create_station(name, city, location, power, connector_type_id):

    url = f"{BASE_URL}/station"

    headers = {
        "Authorization": f"Bearer {TOKEN}",
        "Content-Type": "application/json"
    }

    data = {
        "name": name,
        "city": city,
        "location": location,
        "power": power,
        "connector_type_id": connector_type_id
    }

    response = requests.post(url, json=data, headers=headers)

    print("STATUS:", response.status_code)

    try:
        print(response.json())
    except:
        print(response.status_code)

def update_station(station_id, **fields):

    url = f"{BASE_URL}/station/{station_id}"

    headers = {
        "Authorization": f"Bearer {TOKEN}",
        "Content-Type": "application/json"
    }

    response = requests.patch(url, json=fields, headers=headers)

    print("STATUS:", response.status_code)

    try:
        print(response.json())
    except:
        print(response.text)

def delete_station(station_id):

    url = f"{BASE_URL}/station/{station_id}"

    headers = {
        "Authorization": f"Bearer {TOKEN}"
    }

    response = requests.delete(url, headers=headers)

    print("STATUS:", response.status_code)

    try:
        print(response.json())
    except:
        print(response.status_code)

def get_statistics():

    url = f"{BASE_URL}/admin/statistics"

    headers = {
        "Authorization": f"Bearer {TOKEN}",
        "Content-Type": "application/json"
    }

    response = requests.get(url, headers=headers)

    print("STATUS:", response.status_code)

    try:
        data = response.json()

        print("\nTotal Energy Delivered:", data.get("total_energy_delivered"))
        print("Total Reservations:", data.get("total_reservations"))

        print("\nReservations per Station:")
        for r in data.get("reservations_per_station", []):
            print(f"Station {r['station_id']} → {r['total_reservations']} reservations")

        print("\nEnergy per Station:")
        for e in data.get("energy_per_station", []):
            print(f"Station {e['station_id']} → {e['total_energy']} kWh")

    except:
        print(response.status_code)

book_station(4, "2026-03-13 11:18", "2026-03-13 11:20")