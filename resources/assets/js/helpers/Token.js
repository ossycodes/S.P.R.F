import AppStorage from "./AppStorage";
import Users from "./Users";

class Token {
  isValid(token) {
    const payload = this.payload(token);
    if (!payload) {
      return false;
    }
    //change to your port 
    return payload.iss === "http://127.0.0.1:8000/api/auth/login" ||
      "http://127.0.0.1:8000/api/auth/register"
      ? true
      : false;
  }

  payload(token) {
    const payload = token.split(".")[1];
    return this.decode(payload);
  }

  decode(payload) {
    if (this.isBase64(payload)) {
      return JSON.parse(atob(payload));
    }

    return false;
  }

  isBase64(str) {
    try {
      return btoa(atob(str)).replace(/=/g, "") == str;
    } catch (err) {
      return false;
    }
  }

  hasToken() {
    const storedToken = AppStorage.getToken();
    if (!storedToken) {
      return false;
    }
    return this.isValid(storedToken) ? true : Users.logout();
  }
}

export default Token = new Token();
