import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";

createInertiaApp({
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .mixin({
                methods: {
                    examTimeRangeChecker: function (start_time, end_time) {
                        return (
                            new Date() >= new Date(start_time) &&
                            new Date() <= new Date(end_time)
                        );
                    },

                    examTimeStartChecker: function (start_time) {
                        return new Date() < new Date(start_time);
                    },

                    examTimeEndChecker: function (end_time) {
                        return new Date() > new Date(end_time);
                    },
                },
            })
            .use(plugin)
            .mount(el);
    },
    progress: {
        // The delay after which the progress bar will appear, in milliseconds...
        delay: 250,

        // The color of the progress bar...
        color: "#29d",

        // Whether to include the default NProgress styles...
        includeCSS: true,

        // Whether the NProgress spinner will be shown...
        showSpinner: false,
    },
});
