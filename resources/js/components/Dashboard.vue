<template>
  <div id="dashboard">
    <h3 class="grey--text text--darken-2 mb-2">
      <v-icon class="mb-1" color="grey darken-2">mdi-view-dashboard</v-icon>
      <span class="text-decoration-underline">Dashboard</span>
    </h3>

    <!-- =========================skeleton============================== -->
    <v-row v-show="skeletonLoading">
      <v-col cols="12" sm="12" md="4">
        <v-card class="dashboard-card" elevation="1">
          <v-card-title class="grey--text text--darken-2">
            <v-skeleton-loader
              type="table-heading"
              width="100%"
            ></v-skeleton-loader>
          </v-card-title>

          <v-card-text>
            <v-row>
              <v-col cols="4" class="text-center">
                <v-icon size="70" color="indigo">mdi-account-multiple</v-icon>
              </v-col>
              <v-col cols="8" class="text-right">
                <v-skeleton-loader
                  type="list-item-two-line"
                  width="50%"
                ></v-skeleton-loader>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>

      <v-col cols="12" sm="12" md="4">
        <v-card class="dashboard-card" elevation="1">
          <v-card-title class="grey--text text--darken-2">
            <v-skeleton-loader
              type="table-heading"
              width="100%"
            ></v-skeleton-loader>
          </v-card-title>

          <v-card-text>
            <v-row>
              <v-col cols="4" class="text-center">
                <v-icon size="70" color="teal">mdi-account-tie</v-icon>
              </v-col>
              <v-col cols="8" class="text-right">
                <v-skeleton-loader
                  type="list-item-two-line"
                  width="50%"
                ></v-skeleton-loader>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>

      <v-col cols="12" sm="12" md="4">
        <v-card class="dashboard-card" elevation="1">
          <v-card-title class="grey--text text--darken-2">
            <v-skeleton-loader
              type="table-heading"
              width="100%"
            ></v-skeleton-loader>
          </v-card-title>

          <v-card-text>
            <v-row>
              <v-col cols="4" class="text-center">
                <v-icon size="70" color="orange darken-3"
                  >mdi-account-cancel</v-icon
                >
              </v-col>
              <v-col cols="8" class="text-right">
                <v-skeleton-loader
                  type="list-item-three-line"
                  width="50%"
                ></v-skeleton-loader>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <!-- =========================/skeleton============================== -->

    <!-- ================Card=============== -->
    <v-row v-show="!skeletonLoading">
      <!-- Users -->
      <v-col cols="12" sm="12" md="4">
        <v-card class="dashboard-card" elevation="1">
          <v-card-title class="grey--text text--darken-2">
            <h4 class="indigo--text">USERS</h4>
            <v-spacer></v-spacer>
            <h2 v-if="user.all < 10" class="indigo--text">0{{ user.all }}</h2>
            <h2 v-else class="indigo--text">{{ user.all }}</h2>
          </v-card-title>

          <v-card-text>
            <v-row>
              <v-col cols="4" class="text-center">
                <v-icon size="70" color="indigo">mdi-account-multiple</v-icon>
              </v-col>
              <v-col cols="8" class="text-right">
                <h3 v-if="user.admin < 10">Admin : 0{{ user.admin }}</h3>
                <h3 v-else>Admin : {{ user.admin }}</h3>
                <h3 v-if="user.user < 10">User : 0{{ user.user }}</h3>
                <h3 v-else>User : {{ user.user }}</h3>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>

      <!-- Employee -->
      <v-col cols="12" sm="12" md="4">
        <v-card class="dashboard-card" elevation="1">
          <v-card-title class="grey--text text--darken-2">
            <h4 class="teal--text">EMPLOYEES</h4>
            <v-spacer></v-spacer>
            <h2 class="teal--text" v-if="employee.all < 10">
              0{{ employee.all }}
            </h2>
            <h2 class="teal--text" v-else>
              {{ employee.all }}
            </h2>
          </v-card-title>

          <v-card-text>
            <v-row>
              <v-col cols="4" class="text-center">
                <v-icon size="70" color="teal">mdi-account-tie</v-icon>
              </v-col>
              <v-col cols="8" class="text-right">
                <h3 v-if="employee.senior < 10">
                  Senior : 0{{ employee.senior }}
                </h3>
                <h3 v-else>Senior : {{ employee.senior }}</h3>
                <h3 v-if="employee.junior < 10">
                  Junior : 0{{ employee.junior }}
                </h3>
                <h3 v-else>Junior : {{ employee.junior }}</h3>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>

      <!-- Absent -->
      <v-col cols="12" sm="12" md="4">
        <v-card class="dashboard-card" elevation="1">
          <v-card-title class="grey--text text--darken-2">
            <h4 class="orange--text text--darken-3">ABSENTS</h4>
            <v-spacer></v-spacer>
            <h2 class="orange--text text--darken-3">{{ absent.all }}</h2>
          </v-card-title>

          <v-card-text>
            <v-row>
              <v-col cols="4" class="text-center">
                <v-icon size="70" color="orange darken-3"
                  >mdi-account-cancel</v-icon
                >
              </v-col>
              <v-col cols="8" class="text-right">
                <h3 v-if="absent.weekCount < 10">
                  this Week : 0{{ absent.weekCount }}
                </h3>
                <h3 v-else>this Week : {{ absent.weekCount }}</h3>

                <h3 v-if="absent.monthly < 10">
                  this Month : 0{{ absent.monthly }}
                </h3>
                <h3 v-else>this Month : {{ absent.monthly }}</h3>

                <h3 v-if="absent.year < 10">this Year : 0{{ absent.year }}</h3>
                <h3 v-else>this Year : {{ absent.year }}</h3>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <!-- ================Table================= -->
    <div class="table-report mt-5">
      <v-row>
        <!-- ---weekly--- -->
        <v-col cols="12" sm="12" md="4" class="pa-1">
          <v-card>
            <v-card-title>
              <v-icon size="25" color="grey darken-2" left
                >mdi-account-cancel</v-icon
              >
              <small class="grey--text text--darken-2">
                Absent for this Week</small
              >
              <v-chip
                small
                color="orange--text text--darken-3"
                class="ml-2 font-weight-bold"
                >{{ table.weeklyAbsent.length }}</v-chip
              >
            </v-card-title>

            <v-card-text class="pa-4">
              <v-data-table
                :headers="headers"
                :items="table.weeklyAbsent"
                loading-text="Loading Report data"
                dense
                :items-per-page="-1"
                hide-default-footer
                height="300"
                group-by="employee.name"
              >
                <template
                  v-slot:[`group.header`]="{
                    group,
                    headers,
                    toggle,
                    isOpen,
                    items,
                  }"
                >
                  <td :colspan="headers.length" class="group-header">
                    <v-btn
                      @click="toggle"
                      small
                      icon
                      :ref="group"
                      :data-open="isOpen"
                    >
                      <v-icon v-if="isOpen">mdi-chevron-up</v-icon>
                      <v-icon v-else>mdi-chevron-down</v-icon>
                    </v-btn>

                    <v-chip class="ma-1 font-weight-medium" small>
                      <v-avatar
                        left
                        v-if="items[0].employee.pic == 'default.png'"
                      >
                        <v-img :src="'/image/default.png'" />
                      </v-avatar>
                      <v-avatar left v-else>
                        <v-img :src="'/employees/' + items[0].employee.pic" />
                      </v-avatar>
                      {{ group }} :
                      <span class="red--text font-weight-bold ml-1">{{
                        items.length
                      }}</span>
                    </v-chip>
                  </td>
                </template>

                <template v-slot:[`item.day`]="{ item }">
                  <span class="text-lowercase"> {{ item.day }}</span>
                </template>

                <template v-slot:[`item.date`]="{ item }">
                  <v-chip text-color="blue-grey darken-2" label color="white">
                    <v-avatar left class="mr-0">
                      <v-icon small>mdi-calendar-month</v-icon>
                    </v-avatar>
                    {{ formatDate(item.date) }}
                  </v-chip>
                </template>
              </v-data-table>
            </v-card-text>
          </v-card>
        </v-col>

        <!-- --Monthly-- -->
        <v-col cols="12" sm="12" md="4" class="pa-1">
          <v-card>
            <v-card-title>
              <v-icon size="25" color="grey darken-2" left
                >mdi-account-cancel</v-icon
              >
              <small class="grey--text text--darken-2">
                Absent for this Month</small
              >
              <v-chip
                small
                color="orange--text text--darken-3"
                class="ml-2 font-weight-bold"
                >{{ table.monthlyAbsent.length }}</v-chip
              >
            </v-card-title>

            <v-card-text class="pa-4">
              <v-data-table
                :headers="headers"
                :items="table.monthlyAbsent"
                loading-text="Loading Report data"
                dense
                :items-per-page="-1"
                hide-default-footer
                fixed-header
                height="300"
                group-by="employee.name"
              >
                <template
                  v-slot:[`group.header`]="{
                    group,
                    headers,
                    toggle,
                    isOpen,
                    items,
                  }"
                >
                  <td :colspan="headers.length" class="group-header">
                    <v-btn
                      @click="toggle"
                      small
                      icon
                      :ref="group"
                      :data-open="isOpen"
                    >
                      <v-icon v-if="isOpen">mdi-chevron-up</v-icon>
                      <v-icon v-else>mdi-chevron-down</v-icon>
                    </v-btn>

                    <v-chip class="ma-1 font-weight-medium" small>
                      <v-avatar
                        left
                        v-if="items[0].employee.pic == 'default.png'"
                      >
                        <v-img :src="'/image/default.png'" />
                      </v-avatar>
                      <v-avatar left v-else>
                        <v-img :src="'/employees/' + items[0].employee.pic" />
                      </v-avatar>
                      {{ group }} :
                      <span class="red--text font-weight-bold ml-1">{{
                        items.length
                      }}</span>
                    </v-chip>
                  </td>
                </template>

                <template v-slot:[`item.day`]="{ item }">
                  <span class="text-lowercase"> {{ item.day }}</span>
                </template>

                <template v-slot:[`item.date`]="{ item }">
                  <v-chip text-color="blue-grey darken-2" label color="white">
                    <v-avatar left class="mr-0">
                      <v-icon small>mdi-calendar-month</v-icon>
                    </v-avatar>
                    {{ formatDate(item.date) }}
                  </v-chip>
                </template>
              </v-data-table>
            </v-card-text>
          </v-card>
        </v-col>

        <!-- ----Yearly------ -->
        <v-col cols="12" sm="12" md="4" class="pa-1">
          <v-card>
            <v-card-title>
              <v-icon size="25" color="grey darken-2" left
                >mdi-account-cancel</v-icon
              >
              <small class="grey--text text--darken-2">
                Absent for this Month</small
              >
              <v-chip
                small
                color="orange--text text--darken-3"
                class="ml-2 font-weight-bold"
                >{{ table.yearlyAbsent.length }}</v-chip
              >
            </v-card-title>

            <v-card-text class="pa-4">
              <v-data-table
                :headers="headers"
                :items="table.yearlyAbsent"
                loading-text="Loading Report data"
                dense
                :items-per-page="-1"
                hide-default-footer
                height="300"
                group-by="employee.name"
              >
                <template
                  v-slot:[`group.header`]="{
                    group,
                    headers,
                    toggle,
                    isOpen,
                    items,
                  }"
                >
                  <td :colspan="headers.length" class="group-header">
                    <v-btn
                      @click="toggle"
                      small
                      icon
                      :ref="group"
                      :data-open="isOpen"
                    >
                      <v-icon v-if="isOpen">mdi-chevron-up</v-icon>
                      <v-icon v-else>mdi-chevron-down</v-icon>
                    </v-btn>

                    <v-chip class="ma-1 font-weight-medium" small>
                      <v-avatar
                        left
                        v-if="items[0].employee.pic == 'default.png'"
                      >
                        <v-img :src="'/image/default.png'" />
                      </v-avatar>
                      <v-avatar left v-else>
                        <v-img :src="'/employees/' + items[0].employee.pic" />
                      </v-avatar>
                      {{ group }} :
                      <span class="red--text font-weight-bold ml-1">{{
                        items.length
                      }}</span>
                    </v-chip>
                  </td>
                </template>

                <template v-slot:[`item.day`]="{ item }">
                  <span class="text-lowercase"> {{ item.day }}</span>
                </template>

                <template v-slot:[`item.date`]="{ item }">
                  <v-chip text-color="blue-grey darken-2" label color="white">
                    <v-avatar left class="mr-0">
                      <v-icon small>mdi-calendar-month</v-icon>
                    </v-avatar>
                    {{ formatDate(item.date) }}
                  </v-chip>
                </template>
              </v-data-table>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </div>
  </div>
</template>

<script>
import moment from "moment";
export default {
  data() {
    return {
      skeletonLoading: false,
      headers: [
        {
          align: "start",
        },
        { text: "Employee", value: "employee.name" },
        { text: "Day", value: "day" },
        { text: "Absent Date", value: "date" },
      ],
      weeklyAbsentData: [],
      monthlyAbsentData: [],
      absent: {
        all: "",
        weekCount: "",
        monthly: "",
        year: "",
      },
      employee: {
        all: "",
        senior: "",
        junior: "",
      },
      user: {
        all: "",
        admin: "",
        user: "",
      },
      table: {
        weeklyAbsent: [],
        monthlyAbsent: [],
        yearlyAbsent: [],
      },
    };
  },
  mounted() {
    this.getReport();
  },

  methods: {
    formatDate(value) {
      return moment(value).format("DD-MM-YYYY");
    },

    getReport() {
      axios
        .get("/api/dashboard-data/", {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token"),
          },
        })
        .then((response) => {
          // ----------absent---------
          this.absent.all = response.data.absent.absentCount;
          this.absent.weekCount = response.data.absent.absentWeekCount;
          this.absent.monthly = response.data.absent.absentMonthCount;
          this.absent.year = response.data.absent.absentYearCount;

          // ----------employee---------
          this.employee.all = response.data.employee.allEmployee;
          this.employee.senior = response.data.employee.senior;
          this.employee.junior = response.data.employee.junior;

          // ----------User-------------
          this.user.all = response.data.user.allUser;
          this.user.admin = response.data.user.admin;
          this.user.user = response.data.user.user;

          // ---------Table-------------
          this.table.weeklyAbsent = response.data.absent.weeklyAbsents;
          this.table.monthlyAbsent = response.data.absent.monthlyAbsents;
          this.table.yearlyAbsent = response.data.absent.yearAbsents;
        })
        .catch((errors) => {
          console.log(errors);
        });
    },
  },
};
</script>
