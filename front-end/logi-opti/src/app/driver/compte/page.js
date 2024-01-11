import Titre from "../components/Titre";
import Header from "../components/Header";
import InfosCompte from "../components/InfosCompte";

export default function Compte() {
    return(
        <main>
            <Header/>
            <div className="flex flex-col gap-8 text-black px-10 mt-12  w-full">
                <Titre page="Mon Compte"/>
                <InfosCompte/>
            </div>
        </main>
    );
}