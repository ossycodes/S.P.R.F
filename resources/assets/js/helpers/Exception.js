import User from "./Users";

class Exception {
  handle(error) {
    this.isExpired(error.response.data.error);
  }

  isExpired(error) {
    if (error === "Token is invalid" || (error = "Token is expired")) {
      User.logout();
    }
  }
}

export default Exception = new Exception();
