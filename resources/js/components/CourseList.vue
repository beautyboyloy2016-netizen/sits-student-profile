<template>
  <div class="course-list">
    <div class="row">
      <div class="col-md-4" v-for="course in courses" :key="course.id">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">{{ course.name }}</h3>
            <div class="card-tools">
              <span :class="statusBadge(course.status)">{{ course.status }}</span>
            </div>
          </div>
          <div class="card-body">
            <p>{{ course.description || 'No description' }}</p>
            <div class="d-flex justify-content-between mb-2">
              <span class="badge badge-info">{{ course.levels?.length || 0 }} Levels</span>
              <span class="badge badge-primary">{{ course.classes_count || 0 }} Classes</span>
            </div>

            <!-- Levels List -->
            <div v-if="course.levels?.length > 0" class="mt-3">
              <h6>Levels</h6>
              <ul class="list-group list-group-flush">
                <li v-for="level in course.levels" :key="level.id" class="list-group-item d-flex justify-content-between align-items-center py-1">
                  <span>{{ level.name }}</span>
                  <span class="badge badge-light">#{{ level.sort_order }}</span>
                </li>
              </ul>
            </div>
            <div v-else class="text-muted small mt-2">No levels yet.</div>
          </div>
          <div class="card-footer">
            <button class="btn btn-success btn-sm" @click="openAddLevelModal(course)">
              <i class="fas fa-plus"></i> Level
            </button>
            <button class="btn btn-warning btn-sm ml-1" @click="editCourse(course)">
              <i class="fas fa-edit"></i> Edit
            </button>
            <button class="btn btn-danger btn-sm float-right" @click="confirmDelete(course)">
              <i class="fas fa-trash"></i> Delete
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Add Level Modal -->
    <div class="modal fade" ref="addLevelModal" tabindex="-1" role="dialog" v-if="selectedCourse">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add Level to "{{ selectedCourse.name }}"</h5>
            <button type="button" class="close" @click="closeAddLevelModal"><span>&times;</span></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="saveLevel">
              <div class="form-group">
                <label>Level Name <span class="text-danger">*</span></label>
                <input v-model="levelForm.name" type="text" class="form-control" required placeholder="e.g. Beginner, Elementary">
              </div>
              <div class="form-group">
                <label>Sort Order</label>
                <input v-model.number="levelForm.sort_order" type="number" class="form-control" min="0" placeholder="0">
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary">Save Level</button>
                <button type="button" class="btn btn-secondary" @click="closeAddLevelModal">Cancel</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Course Modal -->
    <div class="modal fade" ref="editCourseModal" tabindex="-1" role="dialog" v-if="editingCourse">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Course</h5>
            <button type="button" class="close" @click="closeEditCourseModal"><span>&times;</span></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="saveCourse">
              <div class="form-group">
                <label>Name <span class="text-danger">*</span></label>
                <input v-model="editForm.name" type="text" class="form-control" required>
              </div>
              <div class="form-group">
                <label>Description</label>
                <textarea v-model="editForm.description" class="form-control" rows="2"></textarea>
              </div>
              <div class="form-group">
                <label>Status</label>
                <select v-model="editForm.status" class="form-control">
                  <option value="active">Active</option>
                  <option value="inactive">Inactive</option>
                </select>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary">Update Course</button>
                <button type="button" class="btn btn-secondary" @click="closeEditCourseModal">Cancel</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CourseList',
  props: {
    initialCourses: { type: Array, required: true },
    apiUrl: { type: String, required: true },
    levelStoreUrl: { type: String, default: '/admin/courses/levels' },
  },
  data() {
    return {
      courses: this.initialCourses,
      selectedCourse: null,
      editingCourse: null,
      levelForm: {
        name: '',
        sort_order: 0,
        course_id: null,
      },
      editForm: {
        name: '',
        description: '',
        status: 'active',
      },
    };
  },
  methods: {
    statusBadge(status) {
      return status === 'active' ? 'badge badge-success' : 'badge badge-secondary';
    },
    openAddLevelModal(course) {
      this.selectedCourse = course;
      this.levelForm = { name: '', sort_order: 0, course_id: course.id };
      this.$nextTick(() => {
        $(this.$refs.addLevelModal).modal('show');
      });
    },
    closeAddLevelModal() {
      $(this.$refs.addLevelModal).modal('hide');
      this.selectedCourse = null;
    },
    async saveLevel() {
      try {
        const response = await axios.post(this.levelStoreUrl, this.levelForm);
        window.Swal.fire('Success', 'Level added successfully.', 'success');
        // Refresh courses
        const coursesResponse = await axios.get(this.apiUrl);
        this.courses = coursesResponse.data;
        this.closeAddLevelModal();
      } catch (error) {
        window.Swal.fire('Error', error.response?.data?.message || 'Failed to add level.', 'error');
      }
    },
    editCourse(course) {
      this.editingCourse = course;
      this.editForm = { ...course };
      this.$nextTick(() => {
        $(this.$refs.editCourseModal).modal('show');
      });
    },
    closeEditCourseModal() {
      $(this.$refs.editCourseModal).modal('hide');
      this.editingCourse = null;
    },
    async saveCourse() {
      try {
        await axios.put(`${this.apiUrl}/${this.editingCourse.id}`, this.editForm);
        window.Swal.fire('Success', 'Course updated successfully.', 'success');
        const coursesResponse = await axios.get(this.apiUrl);
        this.courses = coursesResponse.data;
        this.closeEditCourseModal();
      } catch (error) {
        window.Swal.fire('Error', error.response?.data?.message || 'Failed to update course.', 'error');
      }
    },
    confirmDelete(course) {
      window.Swal.fire({
        title: 'Are you sure?',
        text: `Delete course "${course.name}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
      }).then((result) => {
        if (result.isConfirmed) {
          this.deleteCourse(course.id);
        }
      });
    },
    async deleteCourse(id) {
      try {
        await axios.delete(`${this.apiUrl}/${id}`);
        window.Swal.fire('Deleted!', 'Course has been deleted.', 'success');
        this.courses = this.courses.filter(c => c.id !== id);
      } catch (error) {
        window.Swal.fire('Error', 'Failed to delete course.', 'error');
      }
    },
  },
};
</script>
