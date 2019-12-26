import Token from "./Token";
import AppStorage from "./AppStorage";

class User {

  login(credentials) {
    axios
      .post("/api/auth/login", credentials)
      .then(res => this.responseAfterLogin(res))
      .catch(err => {
        console.log(err);
      });
  }

  responseAfterLogin(res) {
    const access_token = res.data.access_token;
    const username = res.data.user;
    if (Token.isValid(access_token)) {
      AppStorage.store(access_token, username);
      window.location = "/forum";
    }
  }

  logout() {
    AppStorage.clear();
    window.location = "/";
  }

  isAdmin(loggedInUserId) {
    return loggedInUserId === 24;
  }

  isLoggedIn() {
    return Token.hasToken();
  }

  getName() {
    if (!this.isLoggedIn) {
      return false;
    }
    return AppStorage.getName();
  }

  getId() {
    const token = AppStorage.getToken();
    if (!token) {
      return false;
    }
    const payload = Token.payload(AppStorage.getToken());
    if (!payload) {
      return false;
    }
    return payload.sub;
  }

  replyOwner(replyId) {
    return this.getId() === replyId;
  }

  ownQuestion(postId) {
    return this.getId() === postId;
  }
}

export default User = new User();
