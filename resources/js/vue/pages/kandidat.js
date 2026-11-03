import { defineComponent, h } from "vue";

export default defineComponent({
    name: "KandidatPage",
    props: {
        kandidats: { type: Array, default: () => [] },
    },
    setup(props) {
        return () =>
            h("div", { class: "container py-5" }, [
                h("h1", { class: "fw-bold mb-2" }, "Daftar Kandidat"),
                h("p", { class: "text-muted mb-4" }, "Halaman Vue (Kandidat)"),
                props.kandidats.length
                    ? h(
                          "div",
                          { class: "row g-3" },
                          props.kandidats.map((kandidat) =>
                              h("div", { class: "col-md-4" }, [
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
                                      h(
                                          "div",
                                          { class: "card-body text-center" },
                                          [
                                              h(
                                                  "h5",
                                                  {
                                                      class: "card-title fw-bold",
                                                  },
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
                                              h(
                                                  "div",
                                                  { class: "badge bg-primary" },
                                                  `No. ${kandidat.no_urut ?? "-"}`,
                                              ),
                                          ],
                                      ),
                                  ]),
                              ]),
                          ),
                      )
                    : h("p", { class: "text-muted" }, "Belum ada kandidat."),
            ]);
    },
});
