import { defineComponent, h } from "vue";

export default defineComponent({
    name: "SiswaVotingPage",
    props: {
        kandidats: { type: Array, default: () => [] },
        routeDashboard: { type: String, default: "" },
        routeVotingStore: { type: String, default: "" },
    },
    setup(props) {
        return () =>
            h("div", { class: "container py-4" }, [
                h("div", { class: "row mb-4" }, [
                    h("div", { class: "col-12" }, [
                        h("h2", [
                            h("i", { class: "fas fa-vote-yea me-2" }),
                            "Pilih Kandidat",
                        ]),
                        h(
                            "p",
                            { class: "text-muted" },
                            "Pilih salah satu kandidat di bawah ini",
                        ),
                    ]),
                ]),

                props.kandidats.length
                    ? h("div", { class: "row" }, [
                          ...props.kandidats.map((k) =>
                              h("div", { class: "col-md-6 col-lg-4 mb-4" }, [
                                  h(
                                      "div",
                                      { class: "card kandidat-card h-100" },
                                      [
                                          k.foto
                                              ? h("img", {
                                                    src: `/uploads/kandidat/${k.foto}`,
                                                    class: "card-img-top",
                                                    alt: k.nama,
                                                })
                                              : h(
                                                    "div",
                                                    {
                                                        class: "card-img-top d-flex align-items-center justify-content-center bg-secondary",
                                                    },
                                                    [
                                                        h("i", {
                                                            class: "fas fa-user fa-5x text-white",
                                                        }),
                                                    ],
                                                ),

                                          h(
                                              "span",
                                              {
                                                  class: "badge bg-primary position-absolute top-0 end-0 m-3 fs-5",
                                                  style: "z-index: 1;",
                                              },
                                              `No. ${k.no_urut}`,
                                          ),

                                          h("div", { class: "card-body" }, [
                                              h(
                                                  "h4",
                                                  {
                                                      class: "card-title fw-bold",
                                                  },
                                                  k.nama,
                                              ),
                                              h(
                                                  "p",
                                                  { class: "text-muted mb-3" },
                                                  [
                                                      h("i", {
                                                          class: "fas fa-graduation-cap me-1",
                                                      }),
                                                      ` ${k.kelas}`,
                                                  ],
                                              ),

                                              h("div", { class: "mb-3" }, [
                                                  h("h6", [
                                                      h("i", {
                                                          class: "fas fa-bullseye me-1 text-primary",
                                                      }),
                                                      " Visi:",
                                                  ]),
                                                  h(
                                                      "p",
                                                      {
                                                          class: "small text-muted",
                                                      },
                                                      k.visi,
                                                  ),
                                              ]),

                                              h("div", {}, [
                                                  h("h6", [
                                                      h("i", {
                                                          class: "fas fa-tasks me-1 text-success",
                                                      }),
                                                      " Misi:",
                                                  ]),
                                                  h(
                                                      "p",
                                                      {
                                                          class: "small text-muted",
                                                      },
                                                      k.misi,
                                                  ),
                                              ]),
                                          ]),

                                          // Minimal: tombol submit langsung (tanpa modal)
                                          h(
                                              "div",
                                              {
                                                  class: "card-footer bg-white border-top-0",
                                              },
                                              [
                                                  h(
                                                      "form",
                                                      {
                                                          action:
                                                              props.routeVotingStore ||
                                                              "#",
                                                          method: "POST",
                                                      },
                                                      [
                                                          // CSRF harus tetap ada; karena ini wrapper frontend, form CSRF
                                                          // tidak otomatis terisi. Namun sistem Laravel butuh @csrf.
                                                          // Untuk saat ini, tetap render hidden input agar tidak blank.
                                                          h("input", {
                                                              type: "hidden",
                                                              name: "_token",
                                                              value:
                                                                  window?.laravelCsrfToken ||
                                                                  "",
                                                          }),
                                                          h("input", {
                                                              type: "hidden",
                                                              name: "kandidat_id",
                                                              value: k.id,
                                                          }),
                                                          h(
                                                              "button",
                                                              {
                                                                  type: "submit",
                                                                  class: "btn btn-primary btn-vote w-100",
                                                              },
                                                              [
                                                                  h("i", {
                                                                      class: "fas fa-check-circle me-2",
                                                                  }),
                                                                  "Pilih Saya",
                                                              ],
                                                          ),
                                                      ],
                                                  ),
                                              ],
                                          ),
                                      ],
                                  ),
                              ]),
                          ),
                      ])
                    : h("div", { class: "row" }, [
                          h("div", { class: "col-12 text-center py-5" }, [
                              h("i", {
                                  class: "fas fa-user-slash fa-4x text-muted mb-3",
                              }),
                              h(
                                  "h4",
                                  { class: "text-muted" },
                                  "Belum ada kandidat",
                              ),
                              h(
                                  "p",
                                  null,
                                  "Silakan hubungi admin untuk informasi lebih lanjut.",
                              ),
                          ]),
                      ]),

                props.kandidats.length
                    ? h("div", { class: "row mt-4" }, [
                          h("div", { class: "col-12 text-center" }, [
                              h(
                                  "a",
                                  {
                                      href: props.routeDashboard || "#",
                                      class: "btn btn-secondary",
                                  },
                                  [
                                      h("i", {
                                          class: "fas fa-arrow-left me-2",
                                      }),
                                      "Kembali ke Dashboard",
                                  ],
                              ),
                          ]),
                      ])
                    : null,
            ]);
    },
});
