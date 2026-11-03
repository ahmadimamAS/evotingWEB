import { defineComponent, h } from "vue";

export default defineComponent({
    name: "SiswaStatusPage",
    props: {
        sudahMemilih: { type: Boolean, default: false },
        votingAktif: { type: Boolean, default: false },
        siswa: { type: Object, default: null },
        voting: { type: Object, default: null },
        routeDashboard: { type: String, default: "" },
        routeVoting: { type: String, default: "" },
    },
    setup(props) {
        return () =>
            h("div", { class: "container py-4" }, [
                h("div", { class: "row mb-4" }, [
                    h("div", { class: "col-12" }, [
                        h("h2", [
                            h("i", { class: "fas fa-info-circle me-2" }),
                            "Status Pemilihan",
                        ]),
                        h(
                            "p",
                            { class: "text-muted" },
                            "Informasi status pemilihan Anda",
                        ),
                    ]),
                ]),

                h("div", { class: "row mb-4" }, [
                    h("div", { class: "col-md-6 mx-auto" }, [
                        h("div", { class: "card" }, [
                            h("div", { class: "card-body text-center py-4" }, [
                                props.sudahMemilih
                                    ? h("div", [
                                          h("i", {
                                              class: "fas fa-check-circle fa-5x text-success mb-4",
                                          }),
                                          h(
                                              "h3",
                                              "Anda Sudah Melakukan Voting",
                                          ),
                                          h(
                                              "p",
                                              { class: "text-muted" },
                                              "Terima kasih telah berpartisipasi dalam pemilihan OSIS",
                                          ),
                                          props.voting
                                              ? h("div", { class: "mt-4" }, [
                                                    h("hr"),
                                                    h(
                                                        "p",
                                                        { class: "mb-1" },
                                                        "Detail Pemilihan:",
                                                    ),
                                                    h(
                                                        "h5",
                                                        props.voting?.kandidat
                                                            ?.nama ?? "",
                                                    ),
                                                    h(
                                                        "span",
                                                        {
                                                            class: "badge bg-primary",
                                                        },
                                                        [
                                                            "No. ",
                                                            props.voting
                                                                ?.kandidat
                                                                ?.no_urut ?? "",
                                                        ],
                                                    ),
                                                    h(
                                                        "p",
                                                        {
                                                            class: "mt-2 text-muted",
                                                        },
                                                        [
                                                            h("small", [
                                                                h("i", {
                                                                    class: "fas fa-clock me-1",
                                                                }),
                                                                // format datetime tanpa parsing rumit: tampilkan string apa adanya
                                                                props.voting
                                                                    ?.waktu
                                                                    ? ` ${props.voting.waktu}`
                                                                    : "",
                                                            ]),
                                                        ],
                                                    ),
                                                ])
                                              : null,
                                      ])
                                    : h("div", [
                                          h("i", {
                                              class: "fas fa-times-circle fa-5x text-warning mb-4",
                                          }),
                                          h(
                                              "h3",
                                              "Anda Belum Melakukan Voting",
                                          ),
                                          h(
                                              "p",
                                              { class: "text-muted" },
                                              "Silakan pilih kandidat pilihan Anda",
                                          ),
                                          props.votingAktif && props.routeVoting
                                              ? h(
                                                    "a",
                                                    {
                                                        href: props.routeVoting,
                                                        class: "btn btn-primary btn-lg mt-3",
                                                    },
                                                    [
                                                        h("i", {
                                                            class: "fas fa-vote-yea me-2",
                                                        }),
                                                        "Mulai Voting",
                                                    ],
                                                )
                                              : h(
                                                    "div",
                                                    {
                                                        class: "alert alert-warning mt-3",
                                                    },
                                                    [
                                                        h("i", {
                                                            class: "fas fa-lock me-2",
                                                        }),
                                                        "Voting sedang ditutup",
                                                    ],
                                                ),
                                      ]),
                            ]),
                        ]),
                    ]),
                ]),

                h("div", { class: "row" }, [
                    h("div", { class: "col-md-8 mx-auto" }, [
                        h("div", { class: "card" }, [
                            h(
                                "div",
                                { class: "card-header bg-primary text-white" },
                                [
                                    h("h5", { class: "mb-0" }, [
                                        h("i", {
                                            class: "fas fa-info-circle me-2",
                                        }),
                                        "Informasi Pemilihan",
                                    ]),
                                ],
                            ),
                            h("div", { class: "card-body" }, [
                                h(
                                    "table",
                                    { class: "table table-borderless" },
                                    [
                                        h("tbody", [
                                            h("tr", [
                                                h("td", { width: "40%" }, [
                                                    h(
                                                        "strong",
                                                        "Status Voting",
                                                    ),
                                                ]),
                                                h("td", [
                                                    props.votingAktif
                                                        ? h(
                                                              "span",
                                                              {
                                                                  class: "badge bg-success",
                                                              },
                                                              "AKTIF",
                                                          )
                                                        : h(
                                                              "span",
                                                              {
                                                                  class: "badge bg-danger",
                                                              },
                                                              "TIDAK AKTIF",
                                                          ),
                                                ]),
                                            ]),
                                            h("tr", [
                                                h("td", { width: "40%" }, [
                                                    h("strong", "NIS"),
                                                ]),
                                                h("td", props.siswa?.nis ?? ""),
                                            ]),
                                            h("tr", [
                                                h("td", { width: "40%" }, [
                                                    h("strong", "Nama"),
                                                ]),
                                                h(
                                                    "td",
                                                    props.siswa?.nama ?? "",
                                                ),
                                            ]),
                                            h("tr", [
                                                h("td", { width: "40%" }, [
                                                    h("strong", "Kelas"),
                                                ]),
                                                h(
                                                    "td",
                                                    props.siswa?.kelas ?? "",
                                                ),
                                            ]),
                                        ]),
                                    ],
                                ),
                            ]),
                        ]),
                    ]),
                ]),

                h("div", { class: "row mt-4" }, [
                    h("div", { class: "col-12 text-center" }, [
                        h(
                            "a",
                            {
                                href: props.routeDashboard || "#",
                                class: "btn btn-secondary",
                            },
                            [
                                h("i", { class: "fas fa-arrow-left me-2" }),
                                "Kembali ke Dashboard",
                            ],
                        ),
                    ]),
                ]),
            ]);
    },
});
