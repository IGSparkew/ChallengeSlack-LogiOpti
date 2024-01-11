'use client';
import Link from "next/link";
// import Layout from "./components/Layout";
import Header from "@/app/components/Header";
import Sidebar from "@/app/components/Sidebar";
import TopCards from "@/app/components/TopCards";

export default function Chauffeur() {
    return (

        <main>
            {/* <Layout /> */}
            <Header />
            <Sidebar />


        </main>

        // <Link href="/chauffeur" replace>
        //     Dashboard
        // </Link>
    );
}
