<template>
  <div class="student-list">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Students</h3>
        <div class="card-tools">
          <a :href="createUrl" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Add Student
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="row mb-3">
          <div class="col-md-3">
            <input
              v-model="filters.search"
              type="text"
              class="form-control"
              placeholder="Search..."
              @input="debouncedFetch"
            />
          </div>
          <div class="col-md-2">
            <select v-model="filters.status" class="form-control" @change="fetchStudents">
              <option value="">All Status</option>
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
              <option value="graduated">Graduated</option>
              <option value="suspended">Suspended</option>
              <option value="dropped">Dropped</option>
            </select>
          </div>
          <div class="col-md-2">
            <select v-model="filters.gender_id" class="form-control" @change="fetchStudents">
              <option value="">All Genders</option>
              <option v-for="g in genders" :key="g.id" :value="g.id">{{ g.name_kh }}</option>
            </select>
          </div>
          <div class="col-md-2">
            <button class="btn btn-secondary btn-block" @click="resetFilters">
              <i class="fas fa-undo"></i> Reset
            </button>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Photo</th>
                <th>Code</th>
                <th>Name (KH)</th>
                <th>Name (EN)</th>
                <th>Gender</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(student, index) in students.data" :key="student.id">
                <td>{{ students.from + index }}</td>
                <td>
                  <img
                    v-if="student.photo_path"
                    :src="photoUrl(student.photo_path)"
                    class="img-circle elevation-2"
                    style="width: 40px; height: 40px; object-fit: cover;"
                  />
                  <span v-else class="badge badge-secondary">No Photo</span>
                </td>
                <td>{{ student.student_code }}</td>
                <td>{{ student.khmer_name }}</td>
                <td>{{ student.latin_name }}</td>
                <td>{{ student.gender?.name_kh }}</td>
                <td>{{ student.phone }}</td>
                <td>
                  <span :class="statusBadge(student.status)">
                    {{ student.status }}
                  </span>
                </td>
                <td>
                  <a :href="showUrl(student.id)" class="btn btn-info btn-sm" title="View">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a :href="editUrl(student.id)" class="btn btn-warning btn-sm" title="Edit">
                    <i class="fas fa-edit"></i>
                  </a>
                  <button class="btn btn-danger btn-sm" @click="confirmDelete(student)" title="Delete">
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>
              <tr v-if="students.data?.length === 0">
                <td colspan="9" class="text-center">No students found.</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3" v-if="students.last_page > 1">
          <span>Showing {{ students.from }} to {{ students.to }} of {{ students.total }} entries</span>
          <nav>
            <ul class="pagination pagination-sm mb-0">
              <li class="page-item" :class="{ disabled: !students.prev_page_url }">
                <a class="page-link" href="#" @click.prevent="changePage(students.current_page - 1)">Previous</a>
              </li>
              <li
                v-for="page in pageNumbers"
                :key="page"
                class="page-item"
                :class="{ active: page === students.current_page }"
              >
                <a class="page-link" href="#" @click.prevent="changePage(page)">{{ page }}</a>
              </li>
              <li class="page-item" :class="{ disabled: !students.next_page_url }">
                <a class="page-link" href="#" @click.prevent="changePage(students.current_page + 1)">Next</a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'StudentList',
  props: {
    apiUrl: { type: String, required: true },
    baseUrl: { type: String, required: true },
  },
  data() {
    return {
      students: { data: [], from: 1, to: 0, total: 0, current_page: 1, last_page: 1, prev_page_url: null, next_page_url: null },
      genders: [],
      filters: {
        search: '',
        status: '',
        gender_id: '',
      },
      debounceTimer: null,
    };
  },
  computed: {
    createUrl() {
      return `${this.baseUrl}/create`;
    },
    pageNumbers() {
      const pages = [];
      for (let i = 1; i <= this.students.last_page; i++) {
        pages.push(i);
      }
      return pages;
    },
  },
  mounted() {
    this.fetchStudents();
    this.fetchGenders();
  },
  methods: {
    async fetchStudents() {
      try {
        const params = new URLSearchParams({
          page: this.students.current_page,
          ...this.filters,
        });
        const response = await axios.get(`${this.apiUrl}?${params}`);
        this.students = response.data;
      } catch (error) {
        console.error('Error fetching students:', error);
        window.Swal.fire('Error', 'Failed to load students.', 'error');
      }
    },
    async fetchGenders() {
      try {
        const response = await axios.get('/api/genders');
        this.genders = response.data;
      } catch (error) {
        console.error('Error fetching genders:', error);
      }
    },
    debouncedFetch() {
      clearTimeout(this.debounceTimer);
      this.debounceTimer = setTimeout(() => {
        this.students.current_page = 1;
        this.fetchStudents();
      }, 300);
    },
    changePage(page) {
      if (page < 1 || page > this.students.last_page) return;
      this.students.current_page = page;
      this.fetchStudents();
    },
    resetFilters() {
      this.filters = { search: '', status: '', gender_id: '' };
      this.students.current_page = 1;
      this.fetchStudents();
    },
    showUrl(id) {
      return `${this.baseUrl}/${id}`;
    },
    editUrl(id) {
      return `${this.baseUrl}/${id}/edit`;
    },
    photoUrl(path) {
      return `/storage/${path}`;
    },
    statusBadge(status) {
      const map = {
        active: 'badge badge-success',
        inactive: 'badge badge-secondary',
        graduated: 'badge badge-info',
        suspended: 'badge badge-warning',
        dropped: 'badge badge-danger',
      };
      return map[status] || 'badge badge-secondary';
    },
    confirmDelete(student) {
      window.Swal.fire({
        title: 'Are you sure?',
        text: `Delete student "${student.khmer_name}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
      }).then((result) => {
        if (result.isConfirmed) {
          this.deleteStudent(student.id);
        }
      });
    },
    async deleteStudent(id) {
      try {
        await axios.delete(`${this.baseUrl}/${id}`);
        window.Swal.fire('Deleted!', 'Student has been deleted.', 'success');
        this.fetchStudents();
      } catch (error) {
        window.Swal.fire('Error', 'Failed to delete student.', 'error');
      }
    },
  },
};
</script>
