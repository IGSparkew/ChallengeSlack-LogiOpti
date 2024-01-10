import DerniersTrajets from "./components/DerniersTrajets";
import TrajetsAVenir from "./components/TrajetsAVenir";
import Header from "./components/Header";
import ModalArrivee from "./components/ModalArrivee";

export default function Driver() {
    return(
        <main>
            <Header/>
            <div className="flex flex-col gap-8 text-black px-10 mt-12  w-full">
                <div className="u-semi">
                    <h1 className="text-3xl">Trajets</h1>
                    <hr className="w-1/12 h-1 rounded ml-1 bg-redFull"/>
                </div>
                <TrajetsAVenir/>
                <DerniersTrajets/>
            </div>

            <ModalArrivee/>
        </main>
    );
}