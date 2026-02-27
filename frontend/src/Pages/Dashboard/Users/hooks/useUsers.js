import { useState, useEffect } from "react";
import Axios, { ADMIN_USERS } from "../../../../Api/Api";

export default function useUsers() {
  const [users, setUsers] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    loadUsers();
  }, []);

  function loadUsers() {
    setLoading(true);
    Axios.get(`/${ADMIN_USERS}`)
      .then((res) => {
        setUsers(res.data);
        setLoading(false);
      })
      .catch((err) => {
        console.error(err);
        setLoading(false);
      });
  }

  async function handleDelete(id, name) {
    if (!window.confirm(`هل أنت متأكد من حذف المستخدم "${name}"؟`)) {
      return;
    }

    try {
      await Axios.delete(`/${ADMIN_USERS}/${id}`);
      alert("تم حذف المستخدم بنجاح ✅");
      loadUsers();
    } catch (error) {
      console.error(error);
      alert("حدث خطأ في الحذف");
    }
  }

  async function handleSubmit(formData, editMode, currentUser) {
    try {
      const dataToSend = { ...formData };

      if (editMode && !dataToSend.password) {
        delete dataToSend.password;
      }

      if (editMode) {
        await Axios.put(`/${ADMIN_USERS}/${currentUser.id}`, dataToSend);
        alert("تم تعديل المستخدم بنجاح ✅");
      } else {
        await Axios.post(`/${ADMIN_USERS}`, dataToSend);
        alert("تم إضافة المستخدم بنجاح ✅");
      }

      loadUsers();
      return true;
    } catch (error) {
      console.error(error);
      alert("حدث خطأ: " + (error.response?.data?.message || "حاول مرة أخرى"));
      return false;
    }
  }

  async function handleRoleChange(userId, newRole) {
    try {
      await Axios.patch(`/${ADMIN_USERS}/${userId}/role`, { role: newRole });
      alert("تم تغيير الصلاحية بنجاح ✅");
      loadUsers();
    } catch (error) {
      console.error(error);
      alert("حدث خطأ في تغيير الصلاحية");
    }
  }

  return {
    users,
    loading,
    handleDelete,
    handleSubmit,
    handleRoleChange,
  };
}