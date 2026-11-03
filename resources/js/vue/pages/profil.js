import { defineComponent, h } from "vue";

export default defineComponent({
    name: "ProfilPage",
    props: {},
    setup() {
        return () =>
            h("div", { class: "container py-5" }, [
                h("h2", { class: "fw-bold mb-2" }, "Profil OSIS"),
                h("p", { class: "text-muted mb-4" }, "Halaman Vue (Profil)"),
                h("div", { class: "card" }, [
                    h("div", { class: "card-body" }, [
                        h("h5", { class: "card-title fw-bold" }, "Visi & Misi"),
                        h(
                            "p",
                            { class: "card-text text-muted" },
                            "Konten dapat diisi sesuai kebutuhan dari backend (tetap via props).",
                        ),
                    ]),
                ]),
            ]);
    },
});
