<template>
  <div class="room-list">
    <div class="row">
      <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4>Buildings</h4>
          <button class="btn btn-primary btn-sm" @click="openAddBuildingModal">
            <i class="fas fa-plus"></i> Add Building
          </button>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Name</th>
                <th>Status</th>
                <th>Rooms</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="building in buildings" :key="building.id">
                <td>{{ building.name }}</td>
                <td>
                  <span :class="statusBadge(building.status)">{{ building.status }}</span>
                </td>
                <td>{{ building.rooms?.length || 0 }}</td>
                <td>
                  <button class="btn btn-warning btn-sm" @click="editBuilding(building)">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button class="btn btn-danger btn-sm" @click="confirmDeleteBuilding(building)">
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>
              <tr v-if="buildings.length === 0">
                <td colspan="4" class="text-center">No buildings found.</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4>Rooms</h4>
          <button class="btn btn-primary btn-sm" @click="openAddRoomModal">
            <i class="fas fa-plus"></i> Add Room
          </button>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Building</th>
                <th>Room No</th>
                <th>Type</th>
                <th>Capacity</th>
                <th>Monthly Price</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="room in rooms" :key="room.id">
                <td>{{ room.building?.name }}</td>
                <td>{{ room.room_no }}</td>
                <td>{{ room.room_type }}</td>
                <td>{{ room.capacity }}</td>
                <td>{{ room.monthly_price }}</td>
                <td>
                  <span :class="roomStatusBadge(room.status)">{{ room.status }}</span>
                </td>
                <td>
                  <button class="btn btn-warning btn-sm" @click="editRoom(room)">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button class="btn btn-danger btn-sm" @click="confirmDeleteRoom(room)">
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>
              <tr v-if="rooms.length === 0">
                <td colspan="7" class="text-center">No rooms found.</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Add/Edit Building Modal -->
    <div class="modal fade" ref="buildingModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ editingBuilding ? 'Edit Building' : 'Add Building' }}</h5>
            <button type="button" class="close" @click="closeBuildingModal"><span>&times;</span></button>
          </div>
          <form @submit.prevent="saveBuilding">
            <div class="modal-body">
              <div class="form-group">
                <label>Name <span class="text-danger">*</span></label>
                <input v-model="buildingForm.name" type="text" class="form-control" required>
              </div>
              <div class="form-group">
                <label>Status</label>
                <select v-model="buildingForm.status" class="form-control">
                  <option value="active">Active</option>
                  <option value="inactive">Inactive</option>
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click="closeBuildingModal">Close</button>
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Add/Edit Room Modal -->
    <div class="modal fade" ref="roomModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ editingRoom ? 'Edit Room' : 'Add Room' }}</h5>
            <button type="button" class="close" @click="closeRoomModal"><span>&times;</span></button>
          </div>
          <form @submit.prevent="saveRoom">
            <div class="modal-body">
              <div class="form-group">
                <label>Building <span class="text-danger">*</span></label>
                <select v-model="roomForm.building_id" class="form-control" required>
                  <option value="">Select Building</option>
                  <option v-for="b in buildings" :key="b.id" :value="b.id">{{ b.name }}</option>
                </select>
              </div>
              <div class="form-group">
                <label>Room No <span class="text-danger">*</span></label>
                <input v-model="roomForm.room_no" type="text" class="form-control" required>
              </div>
              <div class="form-group">
                <label>Type</label>
                <select v-model="roomForm.room_type" class="form-control">
                  <option value="single">Single</option>
                  <option value="double">Double</option>
                  <option value="shared">Shared</option>
                  <option value="classroom">Classroom</option>
                </select>
              </div>
              <div class="form-group">
                <label>Capacity</label>
                <input v-model.number="roomForm.capacity" type="number" class="form-control" min="0">
              </div>
              <div class="form-group">
                <label>Monthly Price</label>
                <input v-model.number="roomForm.monthly_price" type="number" class="form-control" min="0" step="0.01">
              </div>
              <div class="form-group">
                <label>Status</label>
                <select v-model="roomForm.status" class="form-control">
                  <option value="available">Available</option>
                  <option value="full">Full</option>
                  <option value="maintenance">Maintenance</option>
                  <option value="inactive">Inactive</option>
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click="closeRoomModal">Close</button>
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'RoomList',
  props: {
    initialBuildings: { type: Array, required: true },
    initialRooms: { type: Array, required: true },
    buildingApiUrl: { type: String, required: true },
    roomApiUrl: { type: String, required: true },
  },
  data() {
    return {
      buildings: this.initialBuildings,
      rooms: this.initialRooms,
      editingBuilding: null,
      editingRoom: null,
      buildingForm: {
        name: '',
        status: 'active',
      },
      roomForm: {
        building_id: '',
        room_no: '',
        room_type: 'classroom',
        capacity: 0,
        monthly_price: 0,
        status: 'available',
      },
    };
  },
  methods: {
    statusBadge(status) {
      return status === 'active' ? 'badge badge-success' : 'badge badge-secondary';
    },
    roomStatusBadge(status) {
      const map = {
        available: 'badge badge-success',
        full: 'badge badge-warning',
        maintenance: 'badge badge-danger',
        inactive: 'badge badge-secondary',
      };
      return map[status] || 'badge badge-secondary';
    },
    openAddBuildingModal() {
      this.editingBuilding = null;
      this.buildingForm = { name: '', status: 'active' };
      this.$nextTick(() => {
        $(this.$refs.buildingModal).modal('show');
      });
    },
    editBuilding(building) {
      this.editingBuilding = building;
      this.buildingForm = { ...building };
      this.$nextTick(() => {
        $(this.$refs.buildingModal).modal('show');
      });
    },
    closeBuildingModal() {
      $(this.$refs.buildingModal).modal('hide');
      this.editingBuilding = null;
    },
    async saveBuilding() {
      try {
        if (this.editingBuilding) {
          await axios.put(`${this.buildingApiUrl}/${this.editingBuilding.id}`, this.buildingForm);
          window.Swal.fire('Success', 'Building updated successfully.', 'success');
        } else {
          await axios.post(this.buildingApiUrl, this.buildingForm);
          window.Swal.fire('Success', 'Building created successfully.', 'success');
        }
        window.location.reload();
      } catch (error) {
        window.Swal.fire('Error', error.response?.data?.message || 'Failed to save building.', 'error');
      }
    },
    confirmDeleteBuilding(building) {
      window.Swal.fire({
        title: 'Are you sure?',
        text: `Delete building "${building.name}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
      }).then((result) => {
        if (result.isConfirmed) {
          this.deleteBuilding(building.id);
        }
      });
    },
    async deleteBuilding(id) {
      try {
        await axios.delete(`${this.buildingApiUrl}/${id}`);
        window.Swal.fire('Deleted!', 'Building has been deleted.', 'success');
        this.buildings = this.buildings.filter(b => b.id !== id);
      } catch (error) {
        window.Swal.fire('Error', 'Failed to delete building.', 'error');
      }
    },
    openAddRoomModal() {
      this.editingRoom = null;
      this.roomForm = { building_id: '', room_no: '', room_type: 'classroom', capacity: 0, monthly_price: 0, status: 'available' };
      this.$nextTick(() => {
        $(this.$refs.roomModal).modal('show');
      });
    },
    editRoom(room) {
      this.editingRoom = room;
      this.roomForm = { ...room };
      this.$nextTick(() => {
        $(this.$refs.roomModal).modal('show');
      });
    },
    closeRoomModal() {
      $(this.$refs.roomModal).modal('hide');
      this.editingRoom = null;
    },
    async saveRoom() {
      try {
        if (this.editingRoom) {
          await axios.put(`${this.roomApiUrl}/${this.editingRoom.id}`, this.roomForm);
          window.Swal.fire('Success', 'Room updated successfully.', 'success');
        } else {
          await axios.post(this.roomApiUrl, this.roomForm);
          window.Swal.fire('Success', 'Room created successfully.', 'success');
        }
        window.location.reload();
      } catch (error) {
        window.Swal.fire('Error', error.response?.data?.message || 'Failed to save room.', 'error');
      }
    },
    confirmDeleteRoom(room) {
      window.Swal.fire({
        title: 'Are you sure?',
        text: `Delete room "${room.room_no}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
      }).then((result) => {
        if (result.isConfirmed) {
          this.deleteRoom(room.id);
        }
      });
    },
    async deleteRoom(id) {
      try {
        await axios.delete(`${this.roomApiUrl}/${id}`);
        window.Swal.fire('Deleted!', 'Room has been deleted.', 'success');
        this.rooms = this.rooms.filter(r => r.id !== id);
      } catch (error) {
        window.Swal.fire('Error', 'Failed to delete room.', 'error');
      }
    },
  },
};
</script>
