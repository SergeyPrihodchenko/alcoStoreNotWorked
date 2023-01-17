import { Dialog, DialogTitle } from "@mui/material";
import FormLogin from "./FormLogin";

const SimpleDialog = (props) => {
    const { onClose, selectedValue, open } = props;
  
    const handleClose = () => {
      onClose(selectedValue);
    };
  
    return (
      <Dialog onClose={handleClose} open={open}>
        <DialogTitle>Login</DialogTitle>
            <FormLogin changeTolog={props.changeTolog} handleClose={handleClose}/>
      </Dialog>
    );
  }

export default SimpleDialog;