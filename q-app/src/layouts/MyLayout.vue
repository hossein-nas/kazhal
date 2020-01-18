<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          @click="leftDrawerOpen = !leftDrawerOpen"
          icon="menu"
          aria-label="Menu"
        />

        <q-toolbar-title>
          Quasar App
        </q-toolbar-title>

        <div>Quasar v{{ $q.version }}</div>
      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      bordered
      content-class="bg-grey-2"
    >
      <q-list >
        <q-item-label header>Essential Links</q-item-label>
        <q-item clickable tag="a" to="/" exact>
          <q-item-section avatar>
            <q-icon name="home" />
          </q-item-section>
          <q-item-section>
            <q-item-label >خانه</q-item-label>
            <q-item-label caption>quasar.dev/test</q-item-label>
          </q-item-section>
        </q-item>
        <q-item clickable tag="a" to="/test" exact>
          <q-item-section avatar>
            <q-icon name="build" />
          </q-item-section>
          <q-item-section>
            <q-item-label >صحفه تست</q-item-label>
            <q-item-label caption>quasar.dev/test</q-item-label>
          </q-item-section>
        </q-item>
        <q-item clickable tag="a" to="/test/hey">
          <q-item-section avatar>
            <q-icon name="find_replace" />
          </q-item-section>
          <q-item-section>
            <q-item-label >هی</q-item-label>
            <q-item-label caption>quasar.dev/test/hey</q-item-label>
          </q-item-section>
        </q-item>
      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
export default {
    name: 'MyLayout',

    data () {
        return {
            leftDrawerOpen: false
        }
    }
}
</script>

<style>
  .q-item__label:not(.text-caption){
    font-weight: 600;
  }
</style>
