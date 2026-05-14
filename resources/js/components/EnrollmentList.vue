<template>
  <div class="enrollment-list">
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Student</th>
            <th>Class</th>
            <th>Course</th>
            <th>Academic Year</th>
            <th>Shift</th>
            <th>Enroll Date</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="enrollment in enrollments" :key="enrollment.id">
            <td>{{ enrollment.student?.khmer_name }}</td>
            <td>{{ enrollment.class?.class_code }}</td>
            <td>{{ enrollment.class?.course?.name }}</td>
            <td>{{ enrollment.academic_year?.name }}</td>
            <td>{{ enrollment.shift?.name }}</td>
            <td>{{ enrollment.enroll_date }}</td>
            <td>
              <span :class="statusBadge(enrollment.status)">{{ enrollment.status }}</span>
            </td>
            <td>
              <a :href="editUrl(enrollment.id)" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i>
              </a>
              <button class="btn btn-danger btn-sm" @click="confirmDelete(enrollment)">
                <i class="fas fa-trash"></i>
              </button>
            </td>
          </tr>
          <tr v-if="enrollments.length === 0">
            <td colspan="8" class="text-center">No enrollments found.</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  name: 'EnrollmentList',
  props: {
    initialEnrollments: { type: Array, required: true },
    baseUrl: { type: String, required: true },
  },
  data() {
    return {
      enrollments: this.initialEnrollments,
    };
  },
  methods: {
    statusBadge(status) {
      const map = {
        studying: 'badge badge-success',
        completed: 'badge badge-info',
        dropped: 'badge badge-danger',
        transferred: 'badge badge-warning',
      };
      return map[status] || 'badge badge-secondary';
    },
    editUrl(id) {
      return `${this.baseUrl}/${id}/edit`;
    },
    confirmDelete(enrollment) {
      window.Swal.fire({
        title: 'Are you sure?',
        text: 'Delete this enrollment?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
      }).then((result) => {
        if (result.isConfirmed) {
          this.deleteEnrollment(enrollment.id);
        }
      });
    },
    async deleteEnrollment(id) {
      try {
        await axios.delete(`${this.baseUrl}/${id}`);
        window.Swal.fire('Deleted!', 'Enrollment has been deleted.', 'success');
        this.enrollments = this.enrollments.filter(e => e.id !== id);
      } catch (error) {
        window.Swal.fire('Error', 'Failed to delete enrollment.', 'error');
      }
    },
  },
};
</script>
