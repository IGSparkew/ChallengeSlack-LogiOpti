import Trajet from "./Trajet";

export default function DerniersTrajets({setOpen}) {

    return (
        <div className="flex flex-col gap-5 items-center justify-center bg-white px-5 shadow-box py-5">
            <h2 className="u-semi text-xl underline">Vos derniers trajets</h2>
            <Trajet setOpen={setOpen} infosTrajet={"Trajet du 27/06 à 11H35 : Lyon - Berlin"} /> 
            <Trajet setOpen={setOpen} infosTrajet={"Trajet du 27/06 à 11H35 : Lyon - Berlin"} /> 
            <Trajet setOpen={setOpen} infosTrajet={"Trajet du 27/06 à 11H35 : Lyon - Berlin"} /> 
            <Trajet setOpen={setOpen} infosTrajet={"Trajet du 27/06 à 11H35 : Lyon - Berlin"} /> 
        </div>
    );

}