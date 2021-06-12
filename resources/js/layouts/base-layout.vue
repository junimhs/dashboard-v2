<template>
    <div>
        <navigation />
        <div>
            <slot />
        </div>
        <notification :toast="$page.props.flash"/>
    </div>
</template>

<script>
import Navigation from "../components/Navigation";
import Notification from "../components/Notification";
export default {
    name: "BaseLayout",
    components: {Notification, Navigation}
}
</script>

<style scoped>

</style>
