import {
  BrowserRouter,
  Routes,
  Route,
  Navigate,
} from 'react-router-dom'
import Login from "./Login"
import Dashboard from "./Dashboard"
import React from "react"
import {config} from "../config";

class App extends React.Component {
  state = {
    loggedIn: false
  }

  componentDidMount() {
    this.checkAuth()
  }

  checkAuth () {
    fetch(config.server + 'index.php/auth', {
      credentials: "include",
    })
      .then(response => {
        return response.json()
      })
      .then(data => {
        if (data.status === 'loggedIn') {
          this.setState({
            loggedIn: true
          })
        }
      })
  }

  onLogout = (event) => {
    event.preventDefault()
    fetch(config.server + 'index.php/auth',
      {
        method: 'DELETE',
        credentials: "include",
        headers: {'Content-Type': 'application/json'},
      })
      .then(response => {
        return response.json()
      })
      .then(data => {
        if (data.status === 'success') {
          this.setState({
            loggedIn: false,
          })
        }
      })
  }

  onUpdateAuth = (loggedIn) => {
    this.setState({
      loggedIn: loggedIn
    })
  }

  render() {
    const {loggedIn} = this.state
    return (
      <BrowserRouter>
        <Routes>
          <Route path="/" element={loggedIn ? <Navigate to="/students"/> : <Login onUpdateAuth={this.onUpdateAuth}/>}/>
          <Route path="/students" element={!loggedIn ? <Navigate to="/"/> : <Dashboard onLogout={this.onLogout}/>}>
            <Route path=":page" element={<Dashboard/>}/>
          </Route>
        </Routes>
      </BrowserRouter>
    )
  }
}

export default App;