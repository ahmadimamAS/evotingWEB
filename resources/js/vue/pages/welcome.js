import { defineComponent, h } from "vue";

export default defineComponent({
    name: "WelcomePage",
    props: {
        kandidats: { type: Array, default: () => [] },
        votingAktif: { default: null },
        votingSelesai: { default: null },
        stats: { type: Object, default: () => ({}) },
    },
    setup(props) {
        return () =>
            h("div", { class: "container py-5" }, [
                h("h1", { class: "fw-bold mb-2" }, "E-Voting OSIS"),
                h("p", { class: "text-muted mb-4" }, "Halaman Vue (Welcome)"),
                h("div", { class: "row g-3" }, [
                    h("div", { class: "col-md-4" }, [
                        h("div", { class: "card" }, [
                            h("div", { class: "card-body" }, [
                                h("h5", { class: "card-title" }, "Total Siswa"),
                                h(
                                    "p",
                                    { class: "card-text fw-bold mb-0" },
                                    props.stats?.totalSiswa ?? "-",
                                ),
                            ]),
                        ]),
                    ]),
                    h("div", { class: "col-md-4" }, [
                        h("div", { class: "card" }, [
                            h("div", { class: "card-body" }, [
                                h(
                                    "h5",
                                    { class: "card-title" },
                                    "Sudah Memilih",
                                ),
                                h(
                                    "p",
                                    { class: "card-text fw-bold mb-0" },
                                    props.stats?.sudahMemilih ?? "-",
                                ),
                            ]),
                        ]),
                    ]),
                    h("div", { class: "col-md-4" }, [
                        h("div", { class: "card" }, [
                            h("div", { class: "card-body" }, [
                                h("h5", { class: "card-title" }, "Kandidat"),
                                h(
                                    "p",
                                    { class: "card-text fw-bold mb-0" },
                                    props.stats?.kandidat ?? "-",
                                ),
                            ]),
                        ]),
                    ]),
                ]),
                h("hr", { class: "my-4" }),
                h("h3", { class: "fw-bold mb-3" }, "Kandidat Ketua OSIS"),
                props.kandidats.length
                    ? h(
                          "div",
                          { class: "row g-3" },
                          props.kandidats.map((kandidat) =>
                              h(
                                  "div",
                                  { class: "col-md-4" },
                                  h("div", { class: "card h-100" }, [
                                      kandidat?.foto
                                          ? h("img", {
                                                src: `/uploads/kandidat/${kandidat.foto}`,
                                                class: "card-img-top",
                                                alt:
                                                    kandidat.nama ?? "Kandidat",
                                                style: "height: 200px; object-fit: cover;",
                                            })
                                          : h(
                                                "div",
                                                {
                                                    class: "card-img-top d-flex align-items-center justify-content-center bg-secondary",
                                                    style: "height: 200px;",
                                                },
                                                [
                                                    h("i", {
                                                        class: "fas fa-user fa-4x text-white",
                                                    }),
                                                ],
                                            ),
                                      h("div", { class: "card-body" }, [
                                          h(
                                              "h5",
                                              { class: "card-title fw-bold" },
                                              kandidat.nama ?? "-",
                                          ),
                                          kandidat.kelas
                                              ? h(
                                                    "p",
                                                    {
                                                        class: "text-muted mb-2",
                                                    },
                                                    kandidat.kelas,
                                                )
                                              : null,
                                          h("p", { class: "small mb-0" }, [
                                              h("strong", null, "Visi: "),
                                              kandidat.visi
                                                  ? kandidat.visi.slice(0, 80) +
                                                    "…"
                                                  : "-",
                                          ]),
                                      ]),
                                  ]),
                              ),
                          ),
                      )
                    : h(
                          "p",
                          { class: "text-muted" },
                          "Belum ada kandidat yang terdaftar.",
                      ),
            ]);
    },
});
