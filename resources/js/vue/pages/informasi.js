import { defineComponent, h } from "vue";

export default defineComponent({
    name: "InformasiPage",
    props: {
        waktuMulai: { default: null },
        waktuSelesai: { default: null },
        votingAktif: { default: null },
    },
    setup(props) {
        return () =>
            h("div", { class: "container py-5" }, [
                h("h2", { class: "fw-bold mb-3" }, "Informasi Pemilihan"),
                props.votingAktif
                    ? h(
                          "div",
                          { class: "alert alert-success" },
                          "Voting Sedang Aktif",
                      )
                    : h(
                          "div",
                          { class: "alert alert-warning" },
                          "Voting Belum Dibuka",
                      ),
                h("div", { class: "mt-4" }, [
                    h("h5", { class: "fw-bold" }, "Jadwal Pemilihan"),
                    h("ul", { class: "list-group" }, [
                        h(
                            "li",
                            {
                                class: "list-group-item d-flex justify-content-between align-items-center",
                            },
                            [
                                h("span", "Mulai"),
                                h("strong", props.waktuMulai ?? "-"),
                            ],
                        ),
                        h(
                            "li",
                            {
                                class: "list-group-item d-flex justify-content-between align-items-center",
                            },
                            [
                                h("span", "Selesai"),
                                h("strong", props.waktuSelesai ?? "-"),
                            ],
                        ),
                    ]),
                ]),
            ]);
    },
});
