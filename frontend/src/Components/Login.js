import React from "react";
import {Link} from "react-router-dom";

class Login extends React.Component {
  state = {
    loggedIn: false,
    loginStatus: null,
    login: null,
    password: null,
    remember: null
  }

  onSubmit = (event) => {
    event.preventDefault()

    fetch('http://localhost:8000/index.php/auth',
      {
        method: 'POST',
        credentials: "include",
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
          login: this.state.login,
          password: this.state.password,
          remember: this.state.remember,
        })
      })
      .then(response => {
        return response.json()
      })
      .then(data => {
        if (data.status === 'success') {
          this.setState({
            loggedIn: true,
            loginStatus: 'Success auth'
          })
          this.props.onUpdateAuth(true)
        } else {
          this.setState({
            loginStatus: 'Auth error'
          })
        }
      })
  }

  onChangeInput = (event) => {
    const target = event.target;
    const value = target.type === 'checkbox' ? target.checked : target.value;
    this.setState({
      [target.name]: value
    });
  }

  render() {
    const {
      loginStatus,
      loggedIn
    } = this.state

    return (
      <main>
        <form className="login-form" onSubmit={this.onSubmit}>
          <img src="/image/logo.svg" className="form-logo"
               alt="LMS KnowledgeCity" title="LMS KnowledgeCity"/>
          <div className="title">
            Welcome to the Learning Management System
          </div>
          <div className="subtitle">
            Press login to continue
          </div>
          <div className="input-container">
            <span className="icon icon-user"></span>
            <input className="form-control" type="text" name="login" onChange={this.onChangeInput}
                   placeholder="Username" required/>
          </div>
          <div className="input-container">
            <span className="icon icon-password"></span>
            <input className="form-control" type="password" name="password" onChange={this.onChangeInput}
                   placeholder="Password" required/>
          </div>
          <label className="label">
            <input className="checkbox" type="checkbox"
                   name="remember" onChange={this.onChangeInput}/>
            Remember me
          </label>
          {loginStatus && <div className="login-info">{loginStatus}</div>}
          <button type="submit" className="button orange submit-button">
            Log in
            <span className="icon icon-arrow-right"></span>
          </button>
        </form>
      </main>
    )
  }
}

export default Login;
