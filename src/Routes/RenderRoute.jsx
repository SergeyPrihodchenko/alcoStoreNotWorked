import { Route, Routes } from "react-router-dom";
import AdminPanel from "./../components/AdminPanel";

const RenderRoute = () => {
    return (
        <Routes>
            <Route path="adminPanel" element={<AdminPanel/>}/>
        </Routes>
    );
}

export default RenderRoute;