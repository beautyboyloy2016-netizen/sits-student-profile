<template>
  <div class="class-list">
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Code</th>
            <th>Course</th>
            <th>Level</th>
            <th>Academic Year</th>
            <th>Shift</th>
            <th>Teacher</th>
            <th>Room</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="cls in classes" :key="cls.id">
            <td>{{ cls.class_code }}</td>
            <td>{{ cls.course?.name }}</td>
            <td>{{ cls.level?.name }}</td>
            <td>{{ cls.academic_year?.name }}</td>
            <td>{{ cls.shift?.name }}</td>
            <td>{{ cls.teacher?.name_kh }}</td>
            <td>{{ cls.room?.room_no }}</td>
            <td>
              <span :class="statusBadge(cls.status)">{{ cls.status }}</span>
            </td>
            <td>
              <a :href="scheduleUrl(cls.id)" class="btn btn-info btn-sm" title="Schedules">
                <i class="fas fa-calendar-alt"></i>
              </a>
              <a :href="editUrl(cls.id)" class="btn btn-warning btn-sm" title="Edit">
                <i class="fas fa-edit"></i>
              </a>
              <button class="btn btn-danger btn-sm" @click="confirmDelete(cls)" title="Delete">
                <i class="fas fa-trash"></i>
              </button>
            </td>
          </tr>
          <tr v-if="classes.length === 0">
            <td colspan="9" class="text-center">No classes found.</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ClassList',
  props: {
    initialClasses: { type: Array, required: true },
    baseUrl: { type: String, required: true },
  },
  data() {
    return {
      classes: this.initialClasses,
    };
  },
  methods: {
    statusBadge(status) {
      const map = {
        active: 'badge badge-success',
        completed: 'badge badge-info',
        cancelled: 'badge badge-danger',
      };
      return map[status] || 'badge badge-secondary';
    },
    editUrl(id) {
      return `${this.baseUrl}/${id}/edit`;
    },
    scheduleUrl(id) {
      return `${this.baseUrl}/${id}/schedules`;
    },
    confirmDelete(cls) {
      window.Swal.fire({
        title: 'Are you sure?',
        text: `Delete class "${cls.class_code}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
      }).then((result) => {
        if (result.isConfirmed) {
          this.deleteClass(cls.id);
        }
      });
    },
    async deleteClass(id) {
      try {
        await axios.delete(`${this.baseUrl}/${id}`);
        window.Swal.fire('Deleted!', 'Class has been deleted.', 'success');
        this.classes = this.classes.filter(c => c.id !== id);
      } catch (error) {
        window.Swal.fire('Error', 'Failed to delete class.', 'error');
      }
    },
  },
};
</script>
