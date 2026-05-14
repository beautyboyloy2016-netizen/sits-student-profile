<template>
  <div class="guardian-list">
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Name (KH)</th>
            <th>Name (EN)</th>
            <th>Phone</th>
            <th>Occupation</th>
            <th>Address</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="guardian in guardians" :key="guardian.id">
            <td>{{ guardian.name_kh }}</td>
            <td>{{ guardian.name_en }}</td>
            <td>{{ guardian.phone }}</td>
            <td>{{ guardian.occupation }}</td>
            <td>
              {{ guardian.address?.full_address ||
                 [guardian.address?.village, guardian.address?.street, guardian.address?.house_no].filter(Boolean).join(', ') }}
            </td>
            <td>
              <a :href="editUrl(guardian.id)" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i>
              </a>
              <button class="btn btn-danger btn-sm" @click="confirmDelete(guardian)">
                <i class="fas fa-trash"></i>
              </button>
            </td>
          </tr>
          <tr v-if="guardians.length === 0">
            <td colspan="6" class="text-center">No guardians found.</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  name: 'GuardianList',
  props: {
    initialGuardians: { type: Array, required: true },
    baseUrl: { type: String, required: true },
  },
  data() {
    return {
      guardians: this.initialGuardians,
    };
  },
  methods: {
    editUrl(id) {
      return `${this.baseUrl}/${id}/edit`;
    },
    confirmDelete(guardian) {
      window.Swal.fire({
        title: 'Are you sure?',
        text: `Delete guardian "${guardian.name_kh}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
      }).then((result) => {
        if (result.isConfirmed) {
          this.deleteGuardian(guardian.id);
        }
      });
    },
    async deleteGuardian(id) {
      try {
        await axios.delete(`${this.baseUrl}/${id}`);
        window.Swal.fire('Deleted!', 'Guardian has been deleted.', 'success');
        this.guardians = this.guardians.filter(g => g.id !== id);
      } catch (error) {
        window.Swal.fire('Error', 'Failed to delete guardian.', 'error');
      }
    },
  },
};
</script>
