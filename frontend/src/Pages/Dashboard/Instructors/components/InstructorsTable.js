import React from "react";

export default function InstructorsTable({ instructors, onEdit, onDelete }) {
  return (
    <div className="table-container">
      <table className="instructors-table">
        <thead>
          <tr>
            <th>الصورة</th>
            <th>الاسم</th>
            <th>التخصص</th>
            <th>التقييم</th>
            <th>الخبرة</th>
            <th>الكورسات</th>
            <th>الإجراءات</th>
          </tr>
        </thead>
        <tbody>
          {instructors.map((instructor) => (
            <tr key={instructor.id}>
              <td>
                <div className="instructor-avatar-table">
                  <img
                    src={instructor.avatar || "https://via.placeholder.com/50"}
                    alt={instructor.name}
                    onError={(e) => {
                      e.target.src =
                        "https://via.placeholder.com/50?text=No+Image";
                    }}
                  />
                </div>
              </td>
              <td className="instructor-name-cell">{instructor.name}</td>
              <td>{instructor.specialization}</td>
              <td>⭐ {instructor.rating}</td>
              <td>{instructor.experience_years} سنوات</td>
              <td className="courses-count-cell">
                {instructor.courses_count || 0}
              </td>
              <td>
                <div className="action-buttons">
                  <button
                    onClick={() => onEdit(instructor)}
                    className="edit-btn"
                    title="تعديل"
                  >
                    ✏️
                  </button>
                  <button
                    onClick={() => onDelete(instructor.id, instructor.name)}
                    className="delete-btn"
                    title="حذف"
                  >
                    🗑️
                  </button>
                </div>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}