import { defineComponent, h } from "vue";

export default defineComponent({
    name: "SiswaDashboardPage",
    props: {
        sudahMemilih: { type: Boolean, default: false },
        votingAktif: { type: Boolean, default: false },
        siswa: { type: Object, default: null },
        kandidatDipilih: { type: Object, default: null },
        routeVoting: { type: String, required: false },
    },
    setup(props) {
        return () =>
            h("div", { class: "container py-4" }, [
                h("div", { class: "row mb-4" }, [
                    h("div", { class: "col-12" }, [
                        h("h2", [
                            h("i", { class: "fas fa-user-graduate me-2" }),
                            "Dashboard Siswa",
                        ]),
                        h("p", { class: "text-muted" }, [
                            "Selamat datang, ",
                            props.siswa?.nama ?? "",
                            "!",
                        ]),
                    ]),
                ]),

                h("div", { class: "row mb-4" }, [
                    h(
                        "div",
                        { class: "col-md-6 mx-auto" },
                        props.sudahMemilih
                            ? h("div", { class: "status-card status-sudah" }, [
                                  h("i", {
                                      class: "fas fa-check-circle fa-4x mb-3",
                                  }),
                                  h("h3", "Anda Sudah Memilih"),
                                  h(
                                      "p",
                                      { class: "mb-2" },
                                      "Terima kasih telah berpartisipasi dalam pemilihan OSIS",
                                  ),
                                  props.kandidatDipilih
                                      ? h("div", {}, [
                                            h("hr"),
                                            h(
                                                "p",
                                                { class: "mb-1" },
                                                "Pilihan Anda:",
                                            ),
                                            h("h4", props.kandidatDipilih.nama),
                                            h(
                                                "span",
                                                {
                                                    class: "badge bg-light text-dark",
                                                },
                                                [
                                                    "No. ",
                                                    props.kandidatDipilih
                                                        .no_urut,
                                                ],
                                            ),
                                        ])
                                      : null,
                              ])
                            : h("div", { class: "status-card status-belum" }, [
                                  h("i", { class: "fas fa-clock fa-4x mb-3" }),
                                  h("h3", "Anda Belum Memilih"),
                                  h(
                                      "p",
                                      { class: "mb-0" },
                                      "Silakan pilih kandidat pilihan Anda",
                                  ),
                                  props.votingAktif && props.routeVoting
                                      ? h(
                                            "a",
                                            {
                                                class: "btn btn-light btn-vote mt-3",
                                                href: props.routeVoting,
                                            },
                                            [
                                                h("i", {
                                                    class: "fas fa-vote-yea me-2",
                                                }),
                                                "Mulai Voting",
                                            ],
                                        )
                                      : h(
                                            "button",
                                            {
                                                class: "btn btn-secondary btn-vote mt-3",
                                                disabled: true,
                                            },
                                            [
                                                h("i", {
                                                    class: "fas fa-lock me-2",
                                                }),
                                                "Voting Ditutup",
                                            ],
                                        ),
                              ]),
                    ),
                ]),

                h("div", { class: "row mb-4" }, [
                    h("div", { class: "col-md-4" }, [
                        h("div", { class: "card text-center h-100" }, [
                            h("div", { class: "card-body" }, [
                                h("i", {
                                    class: "fas fa-vote-yea fa-3x text-primary mb-3",
                                }),
                                h("h5", "Status Voting"),
                                props.votingAktif
                                    ? h(
                                          "span",
                                          { class: "badge bg-success" },
                                          "AKTIF",
                                      )
                                    : h(
                                          "span",
                                          { class: "badge bg-danger" },
                                          "TIDAK AKTIF",
                                      ),
                            ]),
                        ]),
                    ]),
                    h("div", { class: "col-md-4" }, [
                        h("div", { class: "card text-center h-100" }, [
                            h("div", { class: "card-body" }, [
                                h("i", {
                                    class: "fas fa-id-card fa-3x text-primary mb-3",
                                }),
                                h("h5", "NIK"),
                                h(
                                    "p",
                                    { class: "mb-0 fw-bold" },
                                    props.siswa?.nik ?? "",
                                ),
                            ]),
                        ]),
                    ]),
                    h("div", { class: "col-md-4" }, [
                        h("div", { class: "card text-center h-100" }, [
                            h("div", { class: "card-body" }, [
                                h("i", {
                                    class: "fas fa-graduation-cap fa-3x text-primary mb-3",
                                }),
                                h("h5", "Kelas"),
                                h(
                                    "p",
                                    { class: "mb-0 fw-bold" },
                                    props.siswa?.kelas ?? "",
                                ),
                            ]),
                        ]),
                    ]),
                ]),
            ]);
    },
});
