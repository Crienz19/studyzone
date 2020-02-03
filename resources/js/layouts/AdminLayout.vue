<template>
  <v-app>
    <v-navigation-drawer app>
      <v-list-item>
        <v-list-item-content>
          <v-list-item-title class="title pa-1">
            HIAP Study Zone
          </v-list-item-title>
          <!-- <v-list-item-subtitle>
            subtext
          </v-list-item-subtitle> -->
        </v-list-item-content>
      </v-list-item>

      <v-divider></v-divider>

      <v-list class="pa-0">
        <v-list-item to="/admin/dashboard">
          <v-list-item-icon>
            <v-icon>mdi-gauge</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>Dashboard</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-divider></v-divider>
        <v-subheader>Monitoring</v-subheader>
        <v-list-item to="/admin/transactions">
          <v-list-item-icon>
            <v-icon>mdi-table</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title>Transactions</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        
        <v-list-item to="/admin/other-service">
          <v-list-item-icon>
            <v-icon>mdi-toolbox-outline</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title>Other Service</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        
        <v-divider></v-divider>
        <v-subheader>Management</v-subheader>
        <v-list-item to="/admin/subscriptions">
          <v-list-item-icon>
            <v-icon>mdi-stack-overflow</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title>Subscriptions</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item to="/admin/cards">
          <v-list-item-icon>
            <v-icon>mdi-card</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title>Cards</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <!-- <v-list-item to="/sa/settings/department">
          <v-list-item-icon>
            <v-icon>mdi-chart-timeline-variant</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title>Subscriptions</v-list-item-title>
          </v-list-item-content>
        </v-list-item> -->
        <v-list-item to="/admin/spaces">
          <v-list-item-icon>
            <v-icon>mdi-stack-overflow</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title>Spaces</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item to="/admin/amenities">
          <v-list-item-icon>
            <v-icon>mdi-coffee-maker</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title>Amenities</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-divider></v-divider>
        <v-subheader>Overall</v-subheader>
        <v-list-item to="/admin/overall/transactions">
          <v-list-item-icon>
            <v-icon>mdi-chart-donut</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title>Transactions</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item to="/admin/overall/services">
          <v-list-item-icon>
            <v-icon>mdi-file-chart</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title>Other Services</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar app>
      <v-app-bar-nav-icon></v-app-bar-nav-icon>
      <v-spacer></v-spacer>
      <v-btn @click="logout" text>Logout</v-btn>
    </v-app-bar>
    <v-content>
      <v-container fluid>
        <router-view></router-view>
      </v-container>
    </v-content>

  </v-app>
</template>

<script>
  export default {
    async mounted() {
      await Echo.channel('transaction')
        .listen('NewTransactionAdded', async (e) => {
          await this.$swal.fire({
            type: 'info',
            title: `${e.transaction.user.name} has clocked in.`,
            text: `Pager No: ${e.transaction.pager_no}`
          })
          await this.$store.dispatch('transaction/addTransaction', e.transaction)
        });
      await Echo.channel('endedTransaction')
        .listen('ClientTransactionHasEnded', (e) => {
            if (e.transaction) {
                this.$swal.fire({
                    type: 'info',
                    title: 'Client\'s Time is approaching...',
                    text: `Pager No: ${e.transaction.pager_no}`
                });
                console.log(e.transaction);
            } else {
                console.log('No Client Done');
            }
        });
    },
    methods: {
      logout () {
        if (localStorage.getItem('access')) {
          localStorage.removeItem('access');
          this.$router.push('/auth/admin/login')
        }
      }
    }
  }
</script>