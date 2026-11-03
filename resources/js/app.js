import { createApp, h } from "vue";
import "./bootstrap";

import WelcomePage from "./vue/pages/welcome";
import KandidatPage from "./vue/pages/kandidat";
import ProfilPage from "./vue/pages/profil";
import InformasiPage from "./vue/pages/informasi";

import SiswaDashboardPage from "./vue/pages/siswa-dashboard";
import SiswaVotingPage from "./vue/pages/siswa-voting";
import SiswaStatusPage from "./vue/pages/siswa-status";

function getProps() {
    return window.__PAGE_PROPS__ || {};
}

function getPageName() {
    return window.__PAGE_NAME__ || "default";
}

const pageName = getPageName();
const props = getProps();

const app = createApp({
    render() {
        if (pageName === "welcome") {
            return h(WelcomePage, { ...props });
        }

        if (pageName === "kandidat") {
            return h(KandidatPage, { ...props });
        }

        if (pageName === "profil") {
            return h(ProfilPage, { ...props });
        }

        if (pageName === "informasi") {
            return h(InformasiPage, { ...props });
        }

        if (pageName === "siswa-dashboard") {
            return h(SiswaDashboardPage, { ...props });
        }

        if (pageName === "siswa-voting") {
            return h(SiswaVotingPage, { ...props });
        }

        if (pageName === "siswa-status") {
            return h(SiswaStatusPage, { ...props });
        }

        // fallback: tetap tampilkan nama halaman + props
        return h("div", { style: { padding: "2rem" } }, [
            h(
                "h2",
                {
                    style: {
                        marginBottom: "1rem",
                        fontFamily: "Poppins, sans-serif",
                    },
                },
                `Vue Page: ${pageName}`,
            ),
            (
                "pre",
                {
                    style: {
                        whiteSpace: "pre-wrap",
                        background: "#fff",
                        padding: "1rem",
                        borderRadius: "12px",
                        border: "1px solid rgba(0,0,0,0.08)",
                    },
                },
                JSON.stringify(props, null, 2),
            ),
        ]);
    },
});

app.mount("#app");
