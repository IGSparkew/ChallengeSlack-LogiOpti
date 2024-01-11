
import Header from "../components/Header";
import Sidebar from "../components/Sidebar";
import TopCards from "../components/TopCards";

export default function Client() {
    return (
        <main className="flex">

            <Sidebar />
            <div>
                <Header />
                <TopCards />

            </div>
            <div> tesst </div>
        </main>
    );
}
