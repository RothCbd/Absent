<template>
  <v-app id="main-app">
    <v-navigation-drawer color="grey lighten-5" app v-model="drawer">
      <v-card flat color="indigo" class="menu-card">
        <v-list class="profile">
          <v-list-item link class="text-center p-0">
            <v-list-item-content>
              <v-list-item-title>
                <v-avatar color="grey lighten-5">
                  <span class="grey--text headline">A</span>
                </v-avatar>

                <h6 class="mt-2 mb-0 white--text text--darken-1">AMIN</h6>
              </v-list-item-title>
              <v-list-item-subtitle class="white--text text--darken-1"
                >admin@admin.com</v-list-item-subtitle
              >
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-card>

      <!-- <v-divider></v-divider> -->
      <!-- ------list------ -->
      <v-list dense class="menu-icon">
        <v-list-item link to="/dashboard">
          <v-list-item-action>
            <v-icon>mdi-view-dashboard</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Dashboard</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item link to="/user">
          <v-list-item-action>
            <v-icon>mdi-account-multiple</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Users</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item link to="/employee">
          <v-list-item-action>
            <v-icon>mdi-account-tie</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Employees</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item link to="/absent">
          <v-list-item-action>
            <v-icon>mdi-account-cancel</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Absent</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item link to="/report">
          <v-list-item-action>
            <v-icon>mdi-chart-bar</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Report</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item link to="/account">
          <v-list-item-action>
            <v-icon>mdi-account-cog</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Account</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>

      <template v-slot:append>
        <div class="pa-2">
          <v-btn
            block
            depressed
            small
            tile
            color="grey lighten-2 grey--text text--darken-2"
          >
            sign out
            <v-icon small>mdi-login-variant</v-icon>
          </v-btn>
        </div>
      </template>
    </v-navigation-drawer>

    <!-- app-bar -->
    <v-app-bar color="white" app flat dense>
      <v-app-bar-nav-icon
        @click.stop="drawer = !drawer"
        color="blue-grey darken-3"
      ></v-app-bar-nav-icon>

      <v-toolbar-title class="indigo--text font-weight-bold">
        Absent Managerment
      </v-toolbar-title>

      <v-spacer></v-spacer>

      <v-btn text icon>
        <v-icon color="indigo">mdi-bell</v-icon>
      </v-btn>

      <v-toolbar-title class="white--text">
        <v-img max-width="90" max-height="90" :src="'/icons/5e53775506160.png'">
        </v-img>
      </v-toolbar-title>
    </v-app-bar>

    <!-- content -->
    <v-main class="mt-5 mx-2">
      <v-container fluid>
        <router-view />
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
export default {
  data() {
    return {
      drawer: null,
    };
  },

  mounted() {},
};
</script>
