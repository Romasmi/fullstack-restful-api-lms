import React from "react"

class StudentsList extends React.Component {
  renderStudents = () => {
    const {data} = this.props
    let studentsTemplate = null

    if (data && data.length) {
      studentsTemplate = data.map(function (student) {
        return (
          <tr key={student.id}>
            <td>
              <span className="icon icon-checked"></span>
            </td>
            <td>
              <div className="user-login">{student.login}</div>
              <div className="user-name">
                Bernardo Santini
              </div>
            </td>
            <td>
              <button type="button" className="edit-button">...</button>
              <div className="group-name">Default Group</div>
            </td>
          </tr>
        )
      })

      return studentsTemplate
    }
  }

  render() {
    return (
      <table className="table user-list-table">
        <tbody>
        {this.renderStudents()}
        </tbody>
      </table>
    );
  }
}

export default StudentsList