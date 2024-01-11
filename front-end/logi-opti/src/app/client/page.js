
import Header from "../components/Header";
import Sidebar from "../components/Sidebar";
import TopCards from "../components/TopCards";
import Table from '../components/table'


export default function Client() {
    return (
        <main className="flex ">

            <Sidebar />
            <div className="flex-auto" >
                <Header />
                <TopCards />
                <Table />

            </div>

        </main>
    );
}
