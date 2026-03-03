try:
    import sklearn
    print(f"Sklearn Version: {sklearn.__version__}")
except ImportError:
    print("Sklearn not installed")
