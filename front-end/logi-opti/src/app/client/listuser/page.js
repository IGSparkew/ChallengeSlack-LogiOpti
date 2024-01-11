import Header from '@/app/components/Header'
import Sidebar from "@/app/components/Sidebar";
import TopCards from "@/app/components/TopCards";
import Table from '@/app/components/tableUser'


export default function Client() {
    return (
        <main className="flex ">

            <Sidebar />
            <div className="flex-auto" >
                <Header />

                <Table />

            </div>

        </main>
    );
}
