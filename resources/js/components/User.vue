<template>
  <div id="user">
    <div>
      <v-row>
        <v-col cols="sm-8">
          <h5 class="grey--text text--darken-2">
            <v-icon left color="grey darken-2">mdi-account-multiple</v-icon>User
            List
            <v-chip color="grey lighten-2 grey--text text--darken-3">{{
              userCount
            }}</v-chip>
          </h5>
        </v-col>
        <v-col cols="sm-4" class="text-right">
          <v-btn small depressed class="add-user white--text"
            ><v-icon left x-small>mdi-plus</v-icon> Add User</v-btn
          >
        </v-col>
      </v-row>

      <!-- -------table---- -->
      <v-card class="mx-auto table-card">
        <v-data-table
          :headers="headers"
          :items="userData"
          :search="search"
          :loading="tableLoading"
          loading-text="Loading users data"
        >
          <template v-slot:[`item.id`]="item">
            {{ item.index + 1 }}
          </template>

          <template v-slot:[`item.name`]="{ item }">
            <v-avatar
              size="35"
              class="m-1"
              left
              v-if="item.profile == 'default.png'"
            >
              <v-img :src="'/image/default.png'" />
            </v-avatar>
            <v-avatar size="35" class="m-1" left v-else>
              <v-img :src="'/profiles/' + item.profile" />
            </v-avatar>

            <small
              class="
                font-weight-medium
                blue-grey--text
                text--darken-3 text-capitalize
              "
            >
              {{ item.name }}
            </small>
          </template>

          <template v-slot:[`item.role`]="{ item }">
            <v-chip
              v-if="item.role == 'admin'"
              small
              label
              class="text-capitalize"
              color="indigo"
              dark
              >{{ item.role }}
            </v-chip>

            <v-chip
              v-else
              small
              label
              class="text-capitalize"
              color="orange"
              dark
              >{{ item.role }}
            </v-chip>
          </template>

          <template v-slot:[`item.actions`]="{ item }">
            <v-icon x-small class="mr-2">mdi-pencil</v-icon>
            <v-icon x-small class="mr-2">mdi-delete</v-icon>
          </template>
        </v-data-table>
      </v-card>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      search: "",
      tableLoading: true,
      headers: [
        {
          text: "No.",
          align: "start",
          value: "id",
        },
        { text: "Name", value: "name" },
        { text: "Email", value: "email" },
        { text: "Role", value: "role" },
        { text: "Phone", value: "phone" },
        { text: "Action", sortable: false, align: "center", value: "actions" },
      ],
      userData: [],
      userCount: "",
    };
  },
  mounted() {
    this.ReadUser();
  },

  methods: {
    ReadUser() {
      axios
        .get("http://127.0.0.1:8000/api/read-user", {
          headers: {
            Authorization:
              "Bearer " + "1|CRLpxKnDG2dZRnT26m2lUMdw09BiLv5If4YgEuLv",
          },
        })
        .then((response) => {
          console.log(response.data);
          this.userData = response.data.data;
          this.userCount = response.data.data.length;
          this.tableLoading = false;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>
