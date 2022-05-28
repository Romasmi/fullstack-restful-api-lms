import React from "react";
import {Link, Route, BrowserRouter} from "react-router-dom";
import Students from "./Dashboard";

class StudentsListPagination extends React.Component {
  state = {
    page: null,
    count: null,
    countPerPage: null
  }

  componentDidMount() {
    this.setState({
      page: parseInt(this.props.page),
      count: parseInt(this.props.count),
      countPerPage: parseInt(this.props.countPerPage)
    })
  }

  renderPagination(from, to, current)
  {
    const pagination = Array.from({length: to - from}, (_, i) => i + from);
    return (
      <React.Fragment>
        {pagination.map((item) => (
          <li key={item} className={current === item ? "active page-item" : "page-item"}
              onClick={() => this.onChangePage(item)}>
            <Link className="page-link"
                  to={{
                    pathname: "/students/" + item
                  }}>
              {item}
            </Link>
          </li>
        ))}
      </React.Fragment>
    )
  }

  onChangePage = (page) => {
    this.setState({
      page: page
    })
    this.props.onChangePage(page)
  }

  render() {
    const {page, count, countPerPage} = this.state
    const lastPage = Math.ceil(count / countPerPage)
    const firstPaginationPage = Math.max(1, page - 2)
    const lastPaginationPage = Math.min(lastPage, page + 2)

    return (
      <nav aria-label="Page navigation">
        <ul className="pagination">
          {page !== 1 &&
            <li className="page-item" onClick={() => this.onChangePage(page - 1)}>
              <Link className="page-link"
                    to={{
                      pathname: "/students/" + (page - 1)
                    }}>
                <span aria-hidden="true">&laquo;</span>
                Prev
              </Link>
            </li>
          }
          {this.renderPagination(firstPaginationPage, lastPaginationPage, page)}
          {page !== lastPage  &&
            <li className="page-item" onClick={() => this.onChangePage(page + 1)}>
              <Link className="page-link"
                    to={{
                      pathname: "/students/" + (page + 1)
                    }}>
                Next
                <span aria-hidden="true">&raquo;</span>
              </Link>
            </li>
          }
        </ul>
      </nav>
    );
  }
}

export default StudentsListPagination