import AppBar from '@mui/material/AppBar';
import Box from '@mui/material/Box';
import Toolbar from '@mui/material/Toolbar';
import LoginIcon from '@mui/icons-material/Login';
import AdminPanelSettingsIcon from '@mui/icons-material/AdminPanelSettings';
import PropTypes from 'prop-types';
import { useState } from 'react';
import { Link } from 'react-router-dom';
import SimpleDialog from './SimpleDialog';
import LogoutIcon from '@mui/icons-material/Logout';


SimpleDialog.propTypes = {
    onClose: PropTypes.func.isRequired,
    open: PropTypes.bool.isRequired,
    selectedValue: PropTypes.string.isRequired,
  };


const Login = () => {

    const [token, setToken] = useState(false);

    const [open, setOpen] = useState(false);
    const handleClickOpen = () => {
        setOpen(true);
    };

  const handleClose = () => {
    setOpen(false);
  };

  const changeTolog = (token) => {
      setToken(token);
  }

    return (
        <>
        <Box sx={{ flexGrow: 1 }}>
            <AppBar position="static">
                <Toolbar style={{justifyContent: 'space-around'}}>
                    <p className='navHeader'>БУХЛИЩЕ ВИНИЩЕ</p>
                    {token === false ? null : <Link to={'adminPanel'}><AdminPanelSettingsIcon/></Link>}
                    {token === false ? <LoginIcon fontSize='large' className='loginIcon' onClick={handleClickOpen}/> : <LogoutIcon fontSize='large' className='loginIcon'/>}
                </Toolbar>
            </AppBar>
        </Box>
        <SimpleDialog
        open={open}
        onClose={handleClose}
        changeTolog={changeTolog}
      /></>
  );
}

export default Login;