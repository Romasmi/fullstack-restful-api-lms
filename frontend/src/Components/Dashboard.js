import React from "react"
import {useParams} from "react-router-dom";
import StudentsList from "./StudentsList"
import StudentsListPagination from "./StudentsListPagination"

function withParams(Component) {
  return props => <Component {...props} params={useParams()}/>;
}

class Dashboard extends React.Component {
  state = {
    students: null,
    page: 1,
    count: null,
    countPerPage: null
  }

  componentDidMount() {
    const page = parseInt(this.props.params.page) || this.state.page
    this.loadStudents(page)
  }

  onChangePage = (page) => {
    this.loadStudents(page)
  }

  loadStudents = (page) => {
    fetch('http://localhost:8000/index.php/users?page=' + page,
      {
        method: 'GET',
        credentials: "include",
        headers: {'Content-Type': 'application/json'},
      })
      .then(response => {
        return response.json()
      })
      .then(data => {
        this.setState({
          students: data.students,
          count: parseInt(data.count),
          countPerPage: parseInt(data.countPerPage),
          page: parseInt(data.page)
        })
      })
  }

  render() {
    const {students, page, count, countPerPage} = this.state
    return (
      <React.Fragment>
        <main className="main-content-wrapper">
          <section className="container">
            <h1 className="main-title">User list</h1>
            {Array.isArray(students) && <StudentsList data={students}/>}
            {count > countPerPage &&
              <StudentsListPagination
                page={page}
                count={count}
                countPerPage={countPerPage}
                onChangePage={this.onChangePage}
              />
            }
          </section>
        </main>
        <footer className="footer">
          <a className="logout-link" href="#" onClick={this.props.onLogout}>
            <span className="icon icon-logout"></span>
            Log out
          </a>
        </footer>
      </React.Fragment>
    );
  }
}

export default withParams(Dashboard);
